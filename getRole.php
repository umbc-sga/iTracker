<?php
	include "../../cgi-bin/mysqlcred.php";

	$id = $_GET['id'];
	$sql = "SELECT * FROM `roleAssignment` 
			join person on (person.id = personId)
			join role on (role.id = roleId)";
	$smlsql = $sql;
	$sql .= "join position on (position.id = person.positionId) 
			where roleAssignment.personId = $id";
	$smlsql .="where roleAssignment.personId = $id";
	$results = mysqli_query($link, $sql);
	if($row = mysqli_fetch_assoc($results)){
		echo json_encode($row);
	}else{

		$results = mysqli_query($link,$smlsql);
		if($row = mysqli_fetch_assoc($results)){
			echo json_encode($row);
		}
	}
?>