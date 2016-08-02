<?php
	include "../../cgi-bin/mysqlcred.php";

	$dept = $_GET['dept'];
	$pos = $_GET['position'];
	$sql = "SELECT person.id FROM roleAssignment join person on (personId = person.id) 
		JOIN position ON(position.id = person.positionId) WHERE departmentId = $dept AND person.positionId = $pos";
	$results = mysqli_query($link, $sql);
	$data;
	if($row = mysqli_fetch_assoc($results)) {
		echo json_encode($row);
	}
?>