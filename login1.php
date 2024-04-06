<?php
require_once 'admin/connect.php';
$faculty = $_POST['faculty'];
$time = date("H:i", strtotime("+6 HOURS"));
$date = date("Y-m-d", strtotime("+6 HOURS"));
$q_faculty = $conn->query("SELECT * FROM `faculty` WHERE `faculty_no` = '$faculty'") or die(mysqli_error($conn));
$f_faculty = $q_faculty->fetch_array();
$faculty_name = $f_faculty['firstname'] . " " . $f_faculty['lastname'];
$conn->query("INSERT INTO `timef` VALUES('', '$faculty', '$faculty_name', '$time', '$date')") or die(mysqli_error($conn));
echo "<h3 class = 'text-muted text-center'>" . $faculty_name . " <label class = 'text-info'>at  " . date("h:i a", strtotime($time)) . "</label></h3>";
?>