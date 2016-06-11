<?php 		//	DO NOT include() THIS FILE ANYWHERE

error_reporting(E_ALL);
ini_set('display_errors', 1);

$dept_dir = str_replace("/includes", "/departments", getcwd());
// echo($dept_dir . "\n");

if (!(file_exists($dept_dir))) {					// if the main "departments" directory does NOT exist
	// echo("NO EXISTING!\n");
	mkdir($dept_dir);
	$deptLanding = fopen($dept_dir . "/index.html", "w");
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


$dept = json_decode(file_get_contents("data/departments/" . $_GET["id"] . "/info.json", FILE_USE_INCLUDE_PATH), true);
$deptURL = str_replace("&", "and", str_replace(" ", "-", (strtolower($dept["name"]))));

$url = $dept_dir . "/" . $deptURL;
// echo($url . "\n");

mkdir($url);

$index = fopen($url . "/index.php", "w");

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