<?php
require_once 'connect.php';

// Validate and sanitize user input
$student_no = mysqli_real_escape_string($conn, $_POST['student_no']);
$firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
$middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
$lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
$course = mysqli_real_escape_string($conn, $_POST['course']);
$year = mysqli_real_escape_string($conn, $_POST['year']);
$image = $_FILES['image'];

// Check if all required fields are filled
if (empty($student_no) || empty($firstname) || empty($lastname) || empty($course) || empty($year) || empty($image['name'])) {
    echo '
        <script type="text/javascript">
            alert("Please fill in all the required fields");
            window.location = "edit_student.php?student_id=' . $_REQUEST['student_id'] . '";
        </script>
    ';
    exit;
}

// Check if the student ID exists in the database
$studentId = $_REQUEST['student_id'];
$checkQuery = "SELECT * FROM `student` WHERE `student_id` = ?";
$checkStmt = mysqli_prepare($conn, $checkQuery);
mysqli_stmt_bind_param($checkStmt, "i", $studentId);
mysqli_stmt_execute($checkStmt);
$checkResult = mysqli_stmt_get_result($checkStmt);

if (mysqli_num_rows($checkResult) === 0) {
    echo '
        <script type="text/javascript">
            alert("Invalid student ID");
            window.location = "student.php";
        </script>
    ';
    exit;
}

// Move the uploaded image file
$image_extension = pathinfo($image['name'], PATHINFO_EXTENSION);
$filename = time() . '.' . $image_extension;
$destination = './uploads/posts/' . $filename;

if (!move_uploaded_file($image['tmp_name'], $destination)) {
    echo '
        <script type="text/javascript">
            alert("Failed to upload image");
            window.location = "edit_student.php?student_id=' . $_REQUEST['student_id'] . '";
        </script>
    ';
    exit;
}

// Update the student record
$updateQuery = "UPDATE `student` SET `student_no` = ?, `firstname` = ?, `middlename` = ?, `lastname` = ?, `course` = ?, `year` = ?, `image` = ? WHERE `student_id` = ?";
$updateStmt = mysqli_prepare($conn, $updateQuery);
mysqli_stmt_bind_param($updateStmt, "sssssssi", $student_no, $firstname, $middlename, $lastname, $course, $year, $filename, $studentId);

if (mysqli_stmt_execute($updateStmt)) {
    echo '
        <script type="text/javascript">
            alert("Successfully Edited");
            window.location = "student.php";
        </script>
    ';
} else {
    echo '
        <script type="text/javascript">
            alert("Failed to update student record");
            window.location = "edit_student.php?student_id=' . $_REQUEST['student_id'] . '";
        </script>
    ';
}

mysqli_stmt_close($updateStmt);
mysqli_close($conn);
?>
