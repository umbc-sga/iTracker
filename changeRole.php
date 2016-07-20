<?php

	include "../../cgi-bin/mysqlcred.php";
	$person = $_GET['person'];
	$dept = $_GET['dept'];
	$role = $_GET['role'];

	if($dept !=0){
		$sql = "UPDATE `roleAssignment` SET `roleId`= $role WHERE `personId` = $person AND `departmentId`= $dept";
	}else{
		$sql = "UPDATE `roleAssignment` SET `roleId`= $role WHERE `personId` = $person";
	}
	mysqli_query($link, $sql);

?>