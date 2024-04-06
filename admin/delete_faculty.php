<?php
	require_once 'connect.php';
	$conn->query("DELETE FROM `faculty` WHERE `faculty_id` = '$_REQUEST[faculty_id]'") or die(mysqli_error());
	header('location:faculty.php');
