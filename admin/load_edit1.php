<?php
require_once 'connect.php';

$q_edit_student = $conn->query("SELECT * FROM `student` WHERE `student_id` = '".$_REQUEST['student_id']."'") or die(mysqli_error($conn));
$f_edit_student = mysqli_fetch_array($q_edit_student);
?>

<form method="POST" action="edit_student_query.php" enctype="multipart/form-data">
	<input type="hidden" name="student_id" value="<?php echo $f_edit_student['student_id']; ?>">
	<div class="modal-body">
		<div class="form-group">
			<label>Student ID:</label>
			<input type="text" name="student_no" value="<?php echo $f_edit_student['student_no']; ?>" required="required" class="form-control" />
		</div>
		<div class="form-group">
			<label>Firstname:</label>
			<input type="text" name="firstname" value="<?php echo $f_edit_student['firstname']; ?>" required="required" class="form-control" />
		</div>
		<div class="form-group">
			<label>Middlename:</label>
			<input type="text" name="middlename" value="<?php echo $f_edit_student['middlename']; ?>" placeholder="(Optional)" class="form-control" />
		</div>
		<div class="form-group">
			<label>Lastname:</label>
			<input type="text" name="lastname" value="<?php echo htmlentities($f_edit_student['lastname']); ?>" required="required" class="form-control" />
		</div>
		<div class="form-group">
			<label>Course:</label>
			<div class="col-md-12 input-group mb-4">
				<?php
				$course_query = "SELECT * FROM course";
				$course_result = mysqli_query($conn, $course_query);
				if (mysqli_num_rows($course_result) > 0) {
					?>
					<select required type="text" name="course" placeholder="course" class="form-control">
						<option value="<?php echo $f_edit_student['course']; ?>" selected><?php echo $f_edit_student['course']; ?></option>
						<?php
						while ($courseItem = mysqli_fetch_array($course_result)) {
							?>
							<option><?php echo $courseItem['course']; ?></option>
							<?php
						}
						?>
					</select>
					<?php
				} else {
					?>
					<h5>No Category Available</h5>
					<?php
				}
				?>
			</div>
		</div>
		<div class="form-group">
			<label>Year:</label>
			<div class="col-md-12 input-group mb-4">
				<?php
				$year_query = "SELECT * FROM year";
				$year_result = mysqli_query($conn, $year_query);
				if (mysqli_num_rows($year_result) > 0) {
					?>
					<select required type="text" name="year" placeholder="year" class="form-control">
						<option value="<?php echo $f_edit_student['year']; ?>" selected><?php echo $f_edit_student['year']; ?></option>
						<?php
						while ($yearItem = mysqli_fetch_array($year_result)) {
							?>
							<option><?php echo $yearItem['year']; ?></option>
							<?php
						}
						?>
					</select>
					<?php
				} else {
					?>
					<h5>No Category Available</h5>
					<?php
				}
				?>
			</div>
		</div>
		<div class="form-group">
			<label>Image:</label>
			<input type="file" name="image" accept="image/*" class="form-control">
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn btn-success" name="edit_admin">
			<span class="glyphicon glyphicon-edit"></span> Save Changes
		</button>
	</div>
</form>
