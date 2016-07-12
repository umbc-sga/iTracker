<?php
	include "../../cgi-bin/mysqlcred.php";
	$id = $_GET['id'];
	$table = $_GET['table'];
	$sql = "INSERT INTO `$table` (`id`)VALUES($id)";
	echo $sql;
	mysqli_query($link,$sql);
?>