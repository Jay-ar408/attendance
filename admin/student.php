<!DOCTYPE html>
<?php
	require_once 'validator.php';
	require_once 'account.php';
?>
<html lang = "eng">
	<head>
		<title>ISU Ilagan Library</title>
		<meta charset = "utf-8" />
		<meta name = "viewport" content = "width=device-width, initial-scale=1" />
		<link rel = "stylesheet" href = "css/bootstrap.css" />
		<link rel = "stylesheet" href = "css/jquery.dataTables.css" />
		<link rel="shortcut icon" type="img/png" href="images/isulogo.png">
	</head>
	<body>
		<nav class = "navbar bg-success navbar-fixed-top">
			<div class = "container-fluid">
				<div class = "navbar-header">
					<a href="home.php"><img src = "images/isulogo.png" width = "50px" height = "50px"></a>
					<p class = "navbar-text pull-right">ISU Ilagan Library</p>
				</div>
				<ul class = "nav navbar-nav navbar-right">
					<li class = "dropdown">
						<a href = "#" class = "dropdown-toggle" data-toggle = "dropdown"><i class = "glyphicon glyphicon-user"></i> <?php echo htmlentities($admin_name)?> <b class = "caret"></b></a>
						<ul class = "dropdown-menu">
							<li><a href = "logout.php"><i class = "glyphicon glyphicon-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
		<div class = "container-fluid" style = "margin-top:70px;">
			<ul class = "nav nav-pills">

				<script>function display_ct6() {
				var x = new Date()
				var ampm = x.getHours( ) >= 12 ? ' PM' : ' AM';
				hours = x.getHours( ) % 12;
				hours = hours ? hours : 12;
				var x1=x.getMonth() + 1+ "/" + x.getDate() + "/" + x.getFullYear();
				x1 = x1 + " - " +  hours + ":" +  x.getMinutes() + ":" +  x.getSeconds() + ":" + ampm;
				document.getElementById('ct6').innerHTML = x1;
				display_c6();
				 }
				 function display_c6(){
				var refresh=0; // Refresh rate in milli seconds
				mytime=setTimeout('display_ct6()',refresh)
				}
				display_c6()
				</script>

				<span id='ct6' class="pull-right" style="font-size:23px"></span>
				<li><a href = "home.php"><span class = "glyphicon glyphicon-home"></span> Home</a></li>
				<li class = "bg-success">
					<a class = "dropdown-toggle" data-toggle = "dropdown" href = "#"><span class = "glyphicon glyphicon-cog"></span> Accounts <span class = "caret"></span></a>
					<ul class = "dropdown-menu">
						<li><a href = "admin.php"><span class = "glyphicon glyphicon-user"></span> Admin</a></li>
						<li><a href = "student.php"><span class = "glyphicon glyphicon-user"></span> Student</a></li>
						<li><a href = "faculty.php"><span class = "glyphicon glyphicon-user"></span> Faculty</a></li>
					</ul>
					<li class = "dropdown">
						<a class = "dropdown-toggle" data-toggle = "dropdown" href = "#"><span class = "glyphicon glyphicon-cog"></span> Records <span class = "caret"></span></a>
						<ul class = "dropdown-menu">
							<li><a href = "record.php"><span class = "glyphicon glyphicon-book"></span> Students Entered</a></li>
							<li><a href = "record1.php"><span class = "glyphicon glyphicon-book"></span> Faculty Entered</a></li>
						</ul>
					</li>
			</ul>
			<br />
			<div class = "alert alert-success">Accounts / Student</div>
			<div class = "modal fade" id = "add_student" tabindex = "-1" role = "dialog" aria-labelledby = "myModallabel">
				<div class = "modal-dialog" role = "document">
					<div class = "modal-content panel-success">
						<div class = "modal-header panel-heading">
							<button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close"><span aria-hidden = "true">&times;</span></button>
							<h4 class = "modal-title" id = "myModallabel">Add new Student</h4>
						</div>
						<form method = "POST" action = "save_student_query.php" enctype = "multipart/form-data">
							<div class  = "modal-body">
								<div class = "form-group">
									<label>Student ID:</label>
									<input type = "password" id = "idnumber" name = "student_no" required = "required" class = "form-control"/>
									<input type="checkbox" onclick="Toggle()">
									<strong>Show ID Number</strong>
								</div>
								<div class = "form-group">
									<label>Firstname:</label>
									<input type = "text" name = "firstname" required = "required" class = "form-control" onkeypress="return a(event);" onkeypress="toTitleCase(str)" />
								</div>
								<div class = "form-group">
									<label>Middlename:</label>
									<input type = "text" name = "middlename" placeholder = "(Optional)" class = "form-control" onkeypress="return a(event);" onkeypress="toTitleCase(str)" />
								</div>
								<div class = "form-group">
									<label>Lastname:</label>
									<input type = "text" name = "lastname" required = "required" class = "form-control" onkeypress="return a(event);" onkeypress="toTitleCase(str)"/>
								</div>
								<div class = "form-group">
									<label>Course:</label>
														<div class="col-md-12 input-group mb-4">
														<?php
														$sex = "SELECT * FROM course";
														$sex_run = mysqli_query($conn,$sex);
														if (mysqli_num_rows($sex_run) > 0)
														 {
															 ?>
															<select required type="text" name="course" placeholder="course" class="form-control" >
																	 <option value="">-Select course-</option>
																	 <?php
																	 foreach ($sex_run as $sexItem){
																		 ?>
																					<option value="<?= $sexItem['course']?>"><?= $sexItem['course']?></option>
																		 <?php
																	 }
																		?>
															 </select>
															 <?php
														}
														else
														 {
														?>
														<h5>No Category Available</h5>
														<?php
														}
														 ?>
														</div>
								</div>
								<div class = "form-group">
									<label>Year:</label>
														<div class="col-md-12 input-group mb-4">
														<?php
														$sex = "SELECT * FROM year";
														$sex_run = mysqli_query($conn,$sex);
														if (mysqli_num_rows($sex_run) > 0)
														 {
															 ?>
															<select required type="text" name="year" placeholder="year" class="form-control" >
																	 <option value="">-Select year-</option>
																	 <?php
																	 foreach ($sex_run as $sexItem){
																		 ?>
																					<option value="<?= $sexItem['year']?>"><?= $sexItem['year']?></option>
																		 <?php
																	 }
																		?>
															 </select>
															 <?php
														}
														else
														 {
														?>
														<h5>No Category Available</h5>
														<?php
														}
														 ?>
														</div>
								</div>
								<div class = "form-group">
										<label>Image:</label>
											<input type="file" name="image" class="button form-control" accept="image/*">
								</div>
							</div>
							<div class = "modal-footer">
								<button  class = "btn btn-success" name = "save"><span class = "glyphicon glyphicon-save"></span> Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class = "modal fade" id = "delete" tabindex = "-1" role = "dialog" aria-labelledby = "myModallabel">
				<div class = "modal-dialog" role = "document">
					<div class = "modal-content ">
						<div class = "modal-body">
							<center><label class = "text-danger">Are you sure you want to delete this record?</label></center>
							<br />
							<center><a class = "btn btn-danger remove_id" ><span class = "glyphicon glyphicon-trash"></span> Yes</a> <button type = "button" class = "btn btn-warning" data-dismiss = "modal" aria-label = "No"><span class = "glyphicon glyphicon-remove"></span> No</button></center>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="edit_student" tabindex="-1" role="dialog" aria-labelledby="myModallabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content panel-success">
					<div class="modal-header panel-heading">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModallabel">Edit Student</h4>
					</div>
					<div id="edit_query"></div>
				</div>
			</div>
		</div>

			<div class = "well col-lg-12">
				<button class = "btn btn-success btn-sm pull-right" type = "button" href = "#" data-toggle = "modal" data-target = "#add_student"><span class = "glyphicon glyphicon-plus"></span> Add new </button>
				<br />
				<br />
				<table id = "table" class = "table table-bordered">
					<thead class = "alert-info">
						<tr>
							<th>Student ID</th>
							<th>Firstname</th>
							<th>Middlename</th>
							<th>Lastname</th>
							<th>Course</th>
							<th>Year</th>
							<th>Image</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$q_student = $conn->query("SELECT * FROM `student`") or die(mysqli_error());
							while($f_student = $q_student->fetch_array()){
						?>
						<tr>
							<td><?php echo $f_student['student_no']?></td>
							<td><?php echo $f_student['firstname']?></td>
							<td><?php echo $f_student['middlename']?></td>
							<td><?php echo $f_student['lastname']?></td>
							<td><?php echo $f_student['course']?></td>
							<td><?php echo $f_student['year']?></td>
							<td> <a target="_blank" href="./uploads/posts/<?= $f_student['image'];?>"> <img src="./uploads/posts/<?= $f_student['image'];?>" width="70px" height="60px"/></a></td>
						<td><a class = "btn btn-danger rstudent_id" name = "<?php echo $f_student['student_id']?>" href = "#" data-toggle = "modal" data-target = "#delete"><span class = "glyphicon glyphicon-remove"></span></a> <a class = "btn btn-warning  estudent_id" name = "<?php echo $f_student['student_id']?>" href = "#" data-toggle = "modal" data-target = "#edit_student"><span class = "glyphicon glyphicon-edit"></span></a></td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</br>
			<button class="pull-right btn-success btn btn-sm" onclick="ExportToExcel('xlsx')">Export</button>
			</div>
			<br />
			<br />
			<br />
		</div>
	</body>
	<script src = "js/jquery.js"></script>
	<script src = "js/bootstrap.js"></script>
	<script src = "js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

<script type="text/javascript">
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>




<script type = "text/javascript">
	$(document).ready(function(){
		$('.rstudent_id').click(function(){
			$student_id = $(this).attr('name');
			$('.remove_id').click(function(){
				window.location = 'delete_student.php?student_id=' + $student_id;
			});
		});
		$('.estudent_id').click(function(){
			$student_id = $(this).attr('name');
			$('#edit_query').load('load_edit1.php?student_id=' + $student_id);
		});
	});
</script>






		 <!-- Only letters-->
<script type = "text/javascript">
function a (event){
	var char = event.which;
	if (char >31 && char != 32 && (char <65 || char >90) && (char < 97 || char >122)){
		return false;

	}
}

</script>

<script type = "text/javascript">

function toTitleCase(str) {
  return str.split(/\s+/).map(s => s.charAt(0).toUpperCase() + s.substring(1).toLowerCase()).join(" ");
}


$('input').on('keyup', function(event) {
  var $t = $(this);
  $t.val(toTitleCase($t.val()));
});



</script>

<script type="text/javascript">
function ExportToExcel(type, fn, dl) {
	 var elt = document.getElementById('table');
	 var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
	 return dl ?
		 XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
		 XLSX.writeFile(wb, fn || ('Attendance list.' + (type || 'xlsx')));
}
</script>

<script>
			// Change the type of input to password or text
			function Toggle() {
					let temp = document.getElementById("idnumber");

					if (temp.type === "password") {
							temp.type = "text";
					}
					else {
							temp.type = "password";
					}
			}
	</script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

</script>
</html>
