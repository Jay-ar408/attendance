<?php
	require_once 'connect.php';
	if (isset($_POST['savefaculty'])) {
		$faculty_no = $_POST['faculty_no'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$department = $_POST['department'];
		$image = $_FILES['image']['name'];
		$image_extension = pathinfo($image, PATHINFO_EXTENSION);
		$filename = time().'.'.$image_extension;

		$conn->query("INSERT INTO `faculty` (`faculty_no`, `firstname`, `lastname`, `department`, `image`) VALUES ('$faculty_no', '$firstname', '$lastname', '$department', '$filename')") or die(mysqli_error($conn));

		move_uploaded_file($_FILES['image']['tmp_name'], './uploads/posts/'.$filename);

		echo '
			<script type="text/javascript">
				alert("Saved Record");
				window.location = "faculty.php";
			</script>
		';
	}
?>
