<?php
	include "../../cgi-bin/mysqlcred.php";

	$positionId = $_GET['positionId'];
	$departmentId = $_GET['departmentId'];

	$sql = "DELETE FROM `departmentPosition` WHERE `positionId` = $positionId AND `departmentId` = $departmentId";
	mysqli_query($link, $sql);
?>