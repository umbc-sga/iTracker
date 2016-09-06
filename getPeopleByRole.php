<?php
	include "../../cgi-bin/mysqlcred.php";
	$roleId = $_GET['id'];
	$sql = "SELECT * FROM `roleAssignment` 
			JOIN person ON (personId = person.id)
			WHERE `roleId` = $roleId";
	$results = mysqli_query($link, $sql);
	$data = array();
	while ($row = mysqli_fetch_assoc($results)) {
		$data[] = $row;
	}
	echo json_encode($data);
?>