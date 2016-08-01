<?php
	include "../../cgi-bin/mysqlcred.php";

	$dept = $_GET['dept'];
	$pos = $_GET['position'];
	$sql = "SELECT person.id, position.needPermission FROM roleAssignment join person on (personId = person.id) 
		JOIN position ON(position.id = person.positionId) WHERE departmentId = $dept AND person.positionId = $pos";
	$results = mysqli_query($link, $sql);
	$data = array();
	while ($row = mysqli_fetch_assoc($results)) {
		array_push($data, $row);
	}
	echo json_encode($data);
?>