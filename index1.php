<!DOCTYPE html>
<?php
require_once 'account.php';
?>
<html lang="eng">

<head>
	<meta charset="utf-8" />
	<title>ISU Ilagan Library</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
	<link rel="stylesheet" href="css/jquery.dataTables.css" />
	<link rel="shortcut icon" type="img/png" href="images/isu1.png">
</head>

<body class="alert-primary">
	<nav class="navbar bg-success navbar-fixed-top ">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="index.php"><img src="images/isu1.png" class="mt-4" width="50px" height="50px" /></a>
				<p class="navbar-text pull-right"> ISU Ilagan Library</p>
			</div>
			<ul class="nav navbar-nav navbar-right">
				<li>
				<li><a class="text-success" href="index.php"><i class="glyphicon glyphicon-user"></i> Student Login</a>
				</li>
				</li>
				<li>
				<li><a class="text-success" href="admin/index.php"><i class="glyphicon glyphicon-user"></i> Admin
						Login</a></li>
				</li>
			</ul>
		</div>
	</nav>

	<div class="modal fade" id="add_faculty" tabindex="-1" role="dialog" aria-labelledby="myModallabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content panel-success">
				<div class="modal-header panel-heading">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModallabel">Add new Faculty</h4>
				</div>
				<form method="POST" action="savefaculty.php" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group">
							<label>Faculty ID:</label>
							<input type="password" id="idnumber" name="faculty_no" required="required"
								class="form-control" />
							<input type="checkbox" onclick="Toggle()">
							<strong>Show ID Number</strong>
						</div>
						<div class="form-group">
							<label>Firstname:</label>
							<input type="text" name="firstname" required="required" class="form-control"
								onkeypress="return a(event);" onkeypress="toTitleCase(str)" />
						</div>
						<div class="form-group">
							<label>Lastname:</label>
							<input type="text" name="lastname" required="required" class="form-control"
								onkeypress="return a(event);" onkeypress="toTitleCase(str)" />
						</div>
						<div class="form-group">
							<label>Department:</label>
							<div class="col-md-12 input-group mb-4">
								<?php
								$sex = "SELECT * FROM department";
								$sex_run = mysqli_query($conn, $sex);
								if (mysqli_num_rows($sex_run) > 0) {
									?>
									<select required type="text" name="department" placeholder="department"
										class="form-control">
										<option value="">-Select Department-</option>
										<?php
										foreach ($sex_run as $sexItem) {
											?>
											<option value="<?= $sexItem['department'] ?>">
												<?= $sexItem['department'] ?>
											</option>
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
							<label>Image: (Optional)</label>
							<input type="file" name="image" class="button form-control" accept="image/*">
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-success" name="savefaculty"><span
								class="glyphicon glyphicon-save"></span> Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>



	<div class="container-fluid">
		<br />
		<br />
		<br />
		<br />
		<div class="col-lg-4"></div>
		<div class="col-lg-4 well">
			<button class="btn btn-success pull-right btn-sm col-lg-3" type="button" href="#" data-toggle="modal"
				data-target="#add_faculty">
				<span class="glyphicon glyphicon-plus"></span> Register</button>
			<br />
			<h2 class="text-success">Faculty Login</h2>

			<script>function display_ct6() {
					var x = new Date()
					var ampm = x.getHours() >= 12 ? ' PM' : ' AM';
					hours = x.getHours() % 12;
					hours = hours ? hours : 12;
					var x1 = x.getMonth() + 1 + "/" + x.getDate() + "/" + x.getFullYear();
					x1 = x1 + " - " + hours + ":" + x.getMinutes() + ":" + x.getSeconds() + ":" + ampm;
					document.getElementById('ct6').innerHTML = x1;
					display_c6();
				}
				function display_c6() {
					var refresh = 0; // Refresh rate in milli seconds
					mytime = setTimeout('display_ct6()', refresh)
				}
				display_c6()
			</script>
			<span id='ct6' class="text-success text-center" style="font-size:23px"></span>

			</br>
			<div id="result"></div>
			<label class="text-success text-center">Faculty ID:</label>
			<input type="password" id="faculty" class="form-control" required="required" />
			<div id="error"></div>
			<br />
			<button type="button" id="login1" class="btn btn-success btn-block"><span
					class="glyphicon glyphicon-login"></span>Login</button>
		</div>
		</form>
	</div>
	</div>
</body>
</br>
</br>
<div class="col-lg-2"></div>
<div class="col-lg-8 well">
	<table id="table1" class="table table-bordered">
		<thead class="alert-info">
			<tr>
				<th>Faculty Name</th>
				<th>Time</th>
				<th>Date</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$q_timef = $conn->query("SELECT * FROM `timef` ") or die(mysqli_error($conn));
			while ($f_timef = $q_timef->fetch_array()) {
				?>
				<tr>

					<td>
						<?php echo ($f_timef['faculty_name']) ?>
					</td>
					<td>
						<?php echo date("h:i a", strtotime($f_timef['time'])) ?>
					</td>
					<td>
						<?php
						$setdate = strtotime($f_timef['date']);
						$friendlyDate = date("F j, Y ", $setdate)
							?>
						<?= $friendlyDate ?>

					</td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
</div>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/login1.js"></script>
<script src="js/jquery.dataTables.js"></script>

<script type="text/javascript">
	$(document).ready(function () {
		$('#table1').DataTable();
	});
</script>
<!-- Only letters-->
<script type="text/javascript">
	function a(event) {
		var char = event.which;
		if (char > 31 && char != 32 && (char < 65 || char > 90) && (char < 97 || char > 122)) {
			return false;

		}
	}

</script>

<script type="text/javascript">

	function toTitleCase(str) {
		return str.split(/\s+/).map(s => s.charAt(0).toUpperCase() + s.substring(1).toLowerCase()).join(" ");
	}


	$('input').on('keyup', function (event) {
		var $t = $(this);
		$t.val(toTitleCase($t.val()));
	});

</script>

<script>
	var input = document.getElementById("faculty");
	input.addEventListener("keypress", function (event) {
		if (event.key === "Enter") {
			event.preventDefault();
			document.getElementById("login1").click();
		}
	});
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

</html>