<?php
	include "../../cgi-bin/mysqlcred.php";
	$id = $_GET['id'];
	$table = $_GET['table'];
	$sql = "SELECT * FROM $table WHERE id = $id";
	echo $sql;
	$result = mysqli_query($link,$sql);
	if(mysqli_num_rows($result) == 0){
		$sql = "INSERT INTO `$table` (`id`)VALUES($id)";
		echo '<br>' . $sql;
		mysqli_query($link,$sql);
	}
?>