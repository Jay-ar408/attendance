<?php
	require_once 'connect.php';
	$conn->query("DELETE FROM `timef` WHERE `timef_id` = '$_REQUEST[timef_id]'") or die(mysqli_error());
	header('location: record1.php');
