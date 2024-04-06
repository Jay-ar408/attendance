<?php
require_once 'connect.php';

// Sanitize and validate user input
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
$middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
$lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
$image = $_FILES['image'];
$image_extension = pathinfo($image['name'], PATHINFO_EXTENSION);
$filename = time() . '.' . $image_extension;

// Check if the username is already taken
$checkQuery = "SELECT * FROM `admin` WHERE `username` = ?";
$checkStmt = mysqli_prepare($conn, $checkQuery);
mysqli_stmt_bind_param($checkStmt, "s", $username);
mysqli_stmt_execute($checkStmt);
$checkResult = mysqli_stmt_get_result($checkStmt);
$existingUser = mysqli_num_rows($checkResult);

if ($existingUser == 1) {
    echo '
        <script type="text/javascript">
            alert("Username already taken");
            window.location = "admin.php";
        </script>
    ';
} else {
    // Update the admin record
    $updateQuery = "UPDATE `admin` SET `username` = ?, `password` = ?, `firstname` = ?, `middlename` = ?, `lastname` = ?, `image` = ? WHERE `admin_id` = ?";
    $updateStmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, "ssssssi", $username, $password, $firstname, $middlename, $lastname, $filename, $_REQUEST['admin_id']);
    mysqli_stmt_execute($updateStmt);

    // Move the uploaded image file
    move_uploaded_file($_FILES['image']['tmp_name'], './uploads/posts/' . $filename);

    echo '
        <script type="text/javascript">
            alert("Successfully Edited");
            window.location = "admin.php";
        </script>
    ';
}
?>
