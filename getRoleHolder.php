<?php

	include "../../cgi-bin/mysqlcred.php";

	$dept = $_GET['dept'];
	$role = $_GET['role'];
	$sql = "SELECT personId, role.name AS role FROM roleAssignment JOIN role ON (role.id = roleId) WHERE departmentId = $dept AND roleId = $role";
	$results = mysqli_query($link, $sql);
	if($row = mysqli_fetch_assoc($results)){
		$data = $row;
	}else{
		$data = new stdClass(); 
	}
	echo json_encode($data);
?>