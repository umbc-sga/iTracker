<html>
<body>
<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	require_once "./basecamp.php";
	// $data = Basecamp("groups.json");
	
	// var_dump($data);
	$groupData = Basecamp("groups.json");
	$groupInfo = Basecamp("groups/".$groupData[12]["id"].".json");

	$people = $groupInfo["memberships"];
	
	$person = Basecamp("people/".$groupInfo["memberships"][0]["id"].".json");
    $personProjs = Basecamp("people/".$groupInfo["memberships"][0]["id"]."/projects.json");

    usort($people, 'compareName');
    echo(gettype($people));
    echo("<br/>");
    var_dump($people);
	
?>
</body>
</html>	 	
