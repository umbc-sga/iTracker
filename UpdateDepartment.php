<?php
	include "../../cgi-bin/mysqlcred.php";

	$descript = $_GET['description'];
	$id = $_GET['id'];
	$sql = "UPDATE `department` SET `description`= '$descript' WHERE `id` = $id";
	echo $sql;
	mysqli_query($link, $sql);
?>