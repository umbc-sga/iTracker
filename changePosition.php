<?php

	include "../../cgi-bin/mysqlcred.php";
	$person = $_GET['person'];
	$position = $_GET['position'];
	$sql = "UPDATE `person` SET `positionId`= $position WHERE id = $person";
	echo $sql;
	mysqli_query($link, $sql);
?>