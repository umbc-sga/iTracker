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
//	$final = json_decode($response, true);
	return $response;
}

function compareName($a, $b){
	return strnatcmp($a['name'], $b['name']);
}

function write($nam,$info){
	$fname = 'data/' . str_replace(' ', '_', $nam);
	$f = fopen($fname, 'w');
	fwrite($f, $info);
	fclose($f);
}

function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
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

mkdir('data',755);
mkdir('data/departments', 755);
mkdir('data/people', 755);
mkdir('data/projects', 755);

$groups = Basecamp('groups.json');
for($gp = 0; $gp < sizeof($groups); $gp++){
	mkdir('data/departments/' . str_replace(' ', '_',$groups[$i]['name']), 755);
	$grpdata = Basecamp('groups/' . $groups[$i]['id'] . '.json');
	
	$peopsid = [];
	$gpprojs=[];
	for($pl = 0; $pl < sizeof($grpdata['memberships']); $pl++){
		$peopsid[] = $grpdata['memberships'][$i]['id'];
		$gpprojects = Basecamp('people/' . $grpdata['memberships'][$i]['id'] . '/projects.json');
		for($pr = 0; $pr < sizeof($gpprojects); $pr++){
			if(!in_array($gpprojects[$pr]['id'], $gpprojs) && !$gpprojects[$pr]['template']){
				$gpprojs[] = $gpprojects[$pr]['id'];
			}
		}
	}
	write('departments/' . str_replace(" ", "_", $groups[$i]['name']) . '/projects.json', json_encode($gpprojs));
	write('departments/' . str_replace(" ", "_", $groups[$i]['name']) . '/people.json', json_encode($peopsid));
}

?>