<?php
	require_once 'connect.php';

	// Retrieve the faculty record to be edited
	$faculty_id = $_REQUEST['faculty_id'];
	$stmt = $conn->prepare("SELECT * FROM `faculty` WHERE `faculty_id` = ?");
	$stmt->bind_param("i", $faculty_id);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$f_edit_faculty = $result->fetch_assoc();
?>

<form method="POST" action="edit_faculty_query.php?faculty_id=<?php echo $f_edit_faculty['faculty_id']; ?>" enctype="multipart/form-data">
	<div class="modal-body">
		<div class="form-group">
			<label>Faculty ID:</label>
			<input type="text" name="faculty_no" value="<?php echo $f_edit_faculty['faculty_no']; ?>" required="required" class="form-control" />
		</div>
		<div class="form-group">
			<label>Firstname:</label>
			<input type="text" name="firstname" value="<?php echo $f_edit_faculty['firstname']; ?>" required="required" class="form-control" />
		</div>
		<div class="form-group">
			<label>Lastname:</label>
			<input type="text" name="lastname" value="<?php echo htmlentities($f_edit_faculty['lastname']); ?>" required="required" class="form-control" />
		</div>
		<div class="form-group">
			<label>Department:</label>
			<select required name="department" class="form-control">
				<option value="<?php echo $f_edit_faculty['department']; ?>"><?php echo $f_edit_faculty['department']; ?></option>
				<?php
					// Fetch departments from the database
					$department_query = $conn->query("SELECT * FROM department");
					while ($department = $department_query->fetch_assoc()) {
						echo '<option value="' . $department['department'] . '">' . $department['department'] . '</option>';
					}
				?>
			</select>
		</div>
		<div class="form-group">
			<label>Image:</label>
			<input type="file" name="image" accept="image/*" class="form-control">
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn btn-warning" name="edit_admin"><span class="glyphicon glyphicon-edit"></span> Save Changes</button>
	</div>
</form>

<?php
	} else {
		echo "Faculty record not found.";
	}

	$stmt->close();
	$conn->close();
?>
