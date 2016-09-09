<?php
	include "../../cgi-bin/mysqlcred.php";

	$id = $_GET['id'];

	$sql = "UPDATE `person` SET `positionId` = NULL WHERE `id` = $id";
	echo($sql);
	mysqli_query($link, $sql);
?>