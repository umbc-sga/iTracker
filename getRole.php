<?php
	include "../../cgi-bin/mysqlcred.php";

	$id = $_GET['id'];
	$sql = "SELECT * FROM `roleAssignment` 
			join person on (person.id = personId)
			Join department on (department.id = departmentid)
			join role on (role.id = roleId)
			where roleAssignment.personId = $id";
	$results = mysqli_query($link, $sql);
	$data;
	if($row = mysqli_fetch_assoc($results)){
		$data = $row;
		echo json_encode($data);
	}
	
?>