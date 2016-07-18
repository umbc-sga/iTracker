<?php

	include "../../cgi-bin/mysqlcred.php";

	$dept = $_GET['dept'];
	$role = $_GET['role'];
	$sql = "SELECT personId FROM roleAssignments WHERE departmentId = $dept AND roleId = $role";
	$results = mysqli_query($link, $sql);
	if($row = mysqli_fetch_assoc($results)){
		$data = $row;
	}
	echo json_encode($data);
?>