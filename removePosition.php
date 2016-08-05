<?php
	include "../../cgi-bin/mysqlcred.php";

	$positionId = $_GET['positionId'];
	$departmentId = $_GET['departmentId'];

	$sql = "SELECT * FROM roleAssignment JOIN person ON (personId= person.id) WHERE departmentId = $departmentId AND person.positionId = $positionId";
	$results = mysqli_query($link, $sql);
	if(mysqli_num_rows($results) == 0){
		$sql = "DELETE FROM `departmentPosition` WHERE `positionId` = $positionId AND `departmentId` = $departmentId";
		echo $sql;
		mysqli_query($link, $sql);
		$sql = "SELECT * FROM departmentPosition WHERE positionId = $positionId";
		$results = mysqli_query($link, $sql);
		if(mysqli_num_rows($results) == 0){
			$sql = "DELETE FROM position WHERE id = $positionId";
			mysqli_query($link, $sql);
		}
	}
?>