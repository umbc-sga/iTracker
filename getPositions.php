<?php
	include "../../cgi-bin/mysqlcred.php";
	$dept = $_GET['dept'];
	$sql = "SELECT * FROM departmentPosition JOIN position ON (position.id = positionId) WHERE departmentId = $dept ";
	$results = mysqli_query($link, $sql);
	$data = array();
	while ($row = mysqli_fetch_assoc($results)) {
		array_push($data, $row);
	}
	echo json_encode($data);
?>