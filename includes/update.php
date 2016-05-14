<?php
//	DO NOT include() THIS FILE ANYWHERE

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../version.php");

if (!(file_exists("/itracker/departments/"))) {
	mkdir("/itracker/departments/");
	$deptLanding = fopen("/itracker/departments/index.html", "w");
	$file = "
	<html>
	<head>
		<meta http-equiv=\"refresh\" content=\"0; URL=http://sga-dev.umbc.edu/itracker/\">
	</head>
	</html>
	";
	fwrite($deptLanding, $file);
	fclose($deptLanding);
}

$url = $_GET["url"];
echo($url);

mkdir("$url");

$index = fopen("$url/index.php", "w");

$text = "
<!DOCTYPE html>
<html>
<head>
	<title>Test Page!</title>
</head>
<body>
Hello, just wanted to let you know that this plan worked! :)
</body>
</html>
";

fwrite($index, $text);

fclose($index);

?>