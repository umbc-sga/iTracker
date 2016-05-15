<?php 		//	DO NOT include() THIS FILE ANYWHERE

error_reporting(E_ALL);
ini_set('display_errors', 1);

$dept_dir = str_replace("/includes", "/departments", getcwd());
// echo($dept_dir . "\n");

if (!(file_exists($dept_dir))) {					// if the main "departments" directory does NOT exits
	// echo("NO EXISTING!\n");
	mkdir($dept_dir);
	$deptLanding = fopen($dept_dir . "/departments/index.html", "w");
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

$url = $dept_dir . "/" . $_GET["url"];
// echo($url . "\n");

mkdir($url);

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