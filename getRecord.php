<?php
	include "../../cgi-bin/mysqlcred.php";

	$table = $_GET['table'];
	$id = $_GET['id'];
	$sql = "SELECT * FROM $table WHERE id = $id";
	$results = mysqli_query($link, $sql);
	$data;
	if($row = mysqli_fetch_assoc($results)){
		$data = $row;
	}
	echo json_encode($data);
?>