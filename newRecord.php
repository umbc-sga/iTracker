<?php
	include "../../cgi-bin/mysqlcred.php";
	$id = $_GET['id'];
	$table = $_GET['table'];
	$sql = "SELECT * FROM $table WHERE id = $id";
	$result = mysqli_query($link,$sql);

	if(mysqli_num_rows($result)){
		$sql = "INSERT INTO `$table` (`id`)VALUES($id)";
		mysqli_query($link,$sql);
	}
?>