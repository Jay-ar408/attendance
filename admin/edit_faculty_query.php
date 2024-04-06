<?php
	require_once 'connect.php';
	$faculty_no = $_POST['faculty_no'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$department = $_POST['department'];
	$image = $_FILES['image'];
	$image_extension = pathinfo($image['name'], PATHINFO_EXTENSION);
	$filename = time().'.'.$image_extension;
		$conn->query("UPDATE `faculty` SET `faculty_no` = '$faculty_no', `firstname` = '$firstname', `lastname` = '$lastname', `department` = '$department', `image` = '$filename' WHERE `faculty_id` = '$_REQUEST[faculty_id]'") or die(mysqli_error());
		move_uploaded_file($_FILES['image']['tmp_name'], './uploads/posts/'.$filename);
		 echo '
			<script type = "text/javascript">
				alert("Successfully Edited");
				window.location = "faculty.php";
			</script>
		';
