<?php
	require_once 'connect.php';
	if(ISSET($_POST['save'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$firstname = $_POST['firstname'];
		$middlename = $_POST['middlename'];
		$lastname = $_POST['lastname'];
		$image = $_FILES['image']['name'];
		$image_extension = pathinfo($image, PATHINFO_EXTENSION);
		$filename = time().'.'.$image_extension;
		$q_checkadmin = $conn->query("SELECT * FROM `admin` WHERE `username` = '$username'") or die(mysqli_error());
		$v_checkadmin = $q_checkadmin->num_rows;
		if($v_checkadmin == 1){
			echo '
				<script type = "text/javascript">
					alert("Username already taken");
					window.location = "admin.php";
				</script>
			';
		}else{
			$conn->query("INSERT INTO `admin` VALUES('', '$username', '$password', '$firstname', '$middlename', '$lastname', '$filename')") or die(mysqli_error());

					 move_uploaded_file($_FILES['image']['tmp_name'], './uploads/posts/'.$filename);
						echo '

				<script type = "text/javascript">
					alert("Saved Record");
					window.location = "admin.php";
				</script>
			';
		}
	}
