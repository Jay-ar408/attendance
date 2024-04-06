<?php
	require_once 'admin/connect.php';
	$faculty = $_POST['faculty'];
	$q_faculty = $conn->query("SELECT * FROM `faculty` WHERE `faculty_no` = '$faculty'") or die(mysqli_error());
	$v_faculty = $q_faculty->num_rows;
	if($v_faculty > 0){
		echo 'Success';
	}else{
		echo 'Error';
	}
