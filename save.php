<?php
	require_once 'connect.php';
	if(ISSET($_POST['save'])){
		$student_no = $_POST['student_no'];
		$firstname = $_POST['firstname'];
		$middlename = $_POST['middlename'];
		$lastname = $_POST['lastname'];
		$course = $_POST['course'];
		$year = $_POST['year'];
		$image = $_FILES['image']['name'];
		$image_extension = pathinfo($image, PATHINFO_EXTENSION);
		$filename = time().'.'.$image_extension;

		$conn->query("INSERT INTO `student` VALUES('', '$student_no','$firstname', '$middlename', '$lastname', '$course', '$year','$filename')") or die(mysqli_error());

		 move_uploaded_file($_FILES['image']['tmp_name'], '/uploads/posts/'.$filename);
			echo '

				<script type = "text/javascript">
					alert("Saved Record");
					window.location = "index.php";
				</script>
			';
	}
