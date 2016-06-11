 <?php
function Basecamp($end){
	$basecamp_url = "https://basecamp.com/2979808/api/v1/$end";
	$appName = 'UMBCSGAiTracker';
	$appContact = 'joshua.massey@umbc.edu';
	
	$helloHeader = "User-Agent: $appName ($appContact)";
	$xheaders = array(                                                'Content-Type: application/json'
	);
	include "/afs/umbc.edu/public/web/sites/sga/dev/cgi-bin/bc_cred.php";
	
	$session = curl_init();
 		
	curl_setopt($session, CURLOPT_URL, $basecamp_url);
	curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($session, CURLOPT_HTTPGET, 1);
	curl_setopt($session, CURLOPT_HTTPHEADER, array($helloHeader, 'Content-Type: application/json'));
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($session,CURLOPT_USERPWD, $credentials);
	curl_setopt($session,CURLOPT_SSL_VERIFYPEER,false);
	 
	$response = curl_exec($session);
	curl_close($session);
	$final = json_decode($response, true);
	return $final;
}

function compareName($a, $b){
	return strnatcmp($a['name'], $b['name']);
}
function write($nam,$info){
	$fname = 'data/' . str_replace(' ', '_', $nam);
	$f = fopen($fname, 'w');
	fwrite($f, $info);
	fclose($f);
	chmod($fname, 0755);
}
function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        return;
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
           deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}

function url($url) {
   $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
   $url = trim($url, "-");
   $url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
   $url = strtolower($url);
   $url = preg_replace('~[^-a-z0-9_]+~', '', $url);
   return $url;
}

function writeDepartment($groupData){
	$text = '<?php $group = json_decode(\'' . json_encode($groupData) . "'); ?>";
	$name = str_replace("&", "and", str_replace(" ", "-", strtolower($groupData['name'])));
	mkdir('departments/' .  $name, 0755);
	$f = fopen('departments/' . $name . '/index.php', 'w+');
	//read in template
	$file = file_get_contents('includes/dept-template.php', FILE_USE_INCLUDE_PATH);
	// echo $file;
	fwrite($f, $text . $file);
	fclose($f);
	chmod('departments/' . $name . '/index.php', 0755);

	//make people page
	mkdir('departments/' .  $name . '/people', 0755);
	$f = fopen('departments/' . $name . '/people/index.php', 'w+');
	//read in template
	$file = file_get_contents('includes/dept-people-template.php', FILE_USE_INCLUDE_PATH);
	// echo $file;
	fwrite($f, $text . $file);
	fclose($f);
	chmod('departments/' . $name . '/people/index.php', 0755);

	//make projects page
	mkdir('departments/' .  $name . '/projects', 0755);
	$f = fopen('departments/' . $name . '/projects/index.php', 'w+');
	//read in template
	$file = file_get_contents('includes/dept-projects-template.php', FILE_USE_INCLUDE_PATH);
	// echo $file;
	fwrite($f, $text . $file);
	fclose($f);
	chmod('departments/' . $name . '/projects/index.php', mode);
}

function WritePerson($person){
	$name = url($person['name']);
	$text = '<?php $person = json_decode(\'' . json_decode($person) . '\');?>';
	mkdir('people/' . $name, 0755);
	$f = fopen('people/' . $name . '/index.php','w');
	$file = file_get_contents('includes/person-template.php', FILE_USE_INCLUDE_PATH);
	fwrite($f, $text . $file);
	fclose($f);
	chmod('people/' . $name . '/index.php', 0755);
}

function WriteProject($project){
	$name = url($project['name']);
	$text = '<?php $project = json_decode(\'' . json_encode($project) . '\');?>';
	mkdir('projects/' . $name, -755);
	$f = fopen('projects/' . $name . '/index.php', 0755);
	fwrite($f, $text . $file);
	fclose($f);
	chmod('projects/' . $name . '/index.php', 0755);
}

deleteDir('data');
deleteDir('departments');
deleteDir('projects');
deleteDir('people');
mkdir('data', 0755);
mkdir('data/departments', 0755);
mkdir('data/people', 0755);
mkdir('data/projects', 0755);
mkdir('departments',0755);
mkdir('people', 0755);
mkdir('projects', 0755);

$groups = Basecamp('groups.json');
$gpids = [];
for($gp = 0; $gp < sizeof($groups); $gp++){
	//create directory
	mkdir('data/departments/' . str_replace(' ', '_',$groups[$gp]['id']), 0755);
	$group = Basecamp('groups/' . $groups[$gp]['id'] . '.json');
	//create inner page files
	writeDepartment($group);
	write('departments/' . $groups[$gp]['id'] . '/info.json', json_encode($group));
	$grpdata = Basecamp('groups/' . $groups[$gp]['id'] . '.json');
	
	$peopsid = [];
	for($pl = 0; $pl < sizeof($grpdata['memberships']); $pl++){
		$peopsid[] = $grpdata['memberships'][$pl]['id'];
		$gpprojects = Basecamp('people/' . $grpdata['memberships'][$pl]['id'] . '/projects.json');
		for($pr = 0; $pr < sizeof($gpprojects); $pr++){
			if(!in_array($gpprojects[$pr]['id'], $gpprojs) && !$gpprojects[$pr]['template'] && !$gpprojects[$pr]['draft']){
				$gpprojs[] = $gpprojects[$pr]['id'];
			}
		}
	}
	write('departments/' . $groups[$gp]['id'] . '/projects.json', json_encode($gpprojs));
	write('departments/' . $groups[$gp]['id'] . '/people.json', json_encode($peopsid)); 
}
write('departments/00-all.json', json_encode($groups));

$people = Basecamp('people.json');
$peopids = [];
for($i = 0; $i < sizeof($people); $i++){
	mkdir('data/people/' . $people[$i]['id'],755);
	$peopids[] = $people[$i]['id'];
	$person = Basecamp('people/' . $people[$i]['id'] .'.json');
	WritePerson($person);
	$projects = Basecamp('people/' . $people[$i]['id'] . '/projects.json');
	write('people/' . $people[$i]['id'] . 'projects.json', json_encode($projects));
	write('people/' . $people[$i]['id'] . 'info.json' , json_encode($person));
}
write('people/00-all.json', json_encode($peopids));


$projects = Basecamp('projects.json');
$projId = [];
for($i = 0; $i < sizeof($projects); $i++){
	$projId[] = $projects[$i]['id'];
	$project = Basecamp('projects/' . $projects[$i]['id'] . '.json');
	WriteProject($project);
	write('projects/' . $projects[$i]['id'] . '.json' ,json_encode($project));
}
write('projects/00-all.json', json_encode($projId));
?>
