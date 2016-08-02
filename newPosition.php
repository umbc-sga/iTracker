<?php
	include "../../cgi-bin/mysqlcred.php";
	$position = $_GET['position'];
	$elevated = $_GET['elevated'];
	$dept = $_GET['dept'];
	$sql = "SELECT * FROM position WHERE position = $position";
	$result = mysqli_query($link, $sql);

	if(!mysqli_fetch_acoss($result)){
		$sql = "INSERT INTO `position`(`position`, `needPermission`) VALUES ('$position', $elevated)";
		mysqli_query($link, $sql);

	}

	$sql = "SELECT * FROM position WHERE position = $position";
	$result = mysqli_query($link, $sql);

	if($row = mysqli_fetch_acoss($result)){
		$id = $row['id'];
		echo $id;
		$sql = "SELECT * FROM `departmentPosition` WHERE `positionId` = $id AND `departmentId` = $dept";
		$result = mysqli_query($link, $sql);
		if(!mysqli_fetch_acoss($result)){
			$sql = "INSERT INTO `departmentPosition`(`positionId`, `departmentId`) VALUES ($id, $dept)";
			mysqli_query($link, $sql);
		}
	}
?>