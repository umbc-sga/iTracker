<?php
	include "../../cgi-bin/mysqlcred.php";

	$table = $_GET['table'];
	$id = $_GET['id'];
	$sql = "SELECT * FROM $table ";
	$sqlsmall = $sql;
	if($table == "person"){
		$sql .= ' JOIN position ON (positionId = position.id)';
	}
	$sql .= " WHERE $table.id = $id";
	$sqlsmall .= " WHERE $table.id = $id";
	$results = mysqli_query($link, $sql);
	$data;
	if($row = mysqli_fetch_assoc($results)){
		$data = $row;
	}else{
		$results = mysqli_query($link, $sqlsmall);
		$data = mysqli_fetch_assoc($results);

	}
	echo json_encode($data);
?>