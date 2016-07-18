<?php
	include "../../cgi-bin/mysqlcred.php";

	$id = $_GET['id'];
	$bio = $_GET['bio'];
	$major = $_GET['major'];
	$class = $_GET['classStanding'];
	$home = $_GET['hometown'];
	$fact = $_GET['fact'];
	$position = $_GET['position'];
	$sql = "UPDATE `person` SET `bio`= '$bio',`major`= '$major',`classStanding`= '$class',`hometown`= '$home',`fact`='$fact',`position`= '$position' WHERE `id` = $id";

	$results = mysqli_query($link, $sql);
	if($row = mysqli_fetch_assoc($results)){
		$data = $row;
	}
	echo json_encode($data);
?>