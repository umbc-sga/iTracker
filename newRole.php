<?php
	include "../../cgi-bin/mysqlcred.php";

	$personId = $_GET['personId'];
	$deptId = $_GET['deptId'];
	$check = "SELECT * FROM `roleAssignment` WHERE `personId` = $personId AND `departmentId` = $deptId";
	$result = mysqli_query($link, $check);
	$row = mysqli_fetch_assoc($result);
	echo json_encode($row);
	if(!mysqli_fetch_assoc($result)){

		$sql = "INSERT INTO `roleAssignment`(`personId`, `roleId`, `departmentId`) VALUES ($personId, 3, $deptId)";
		echo $sql;
		mysqli_query($link, $sql);
	}
?>