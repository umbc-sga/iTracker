<?php
	include "../../cgi-bin/mysqlcred.php";

	$id = $_GET['id'];

	$sql = "UPDATE TABLE `person` SET `positionId = NULL WHERE id = $id";

	mysqli_query($link, $sql);
?>