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
				<li class = "dropdown">
					<a class = "dropdown-toggle" data-toggle = "dropdown" href = "#"><span class = "glyphicon glyphicon-cog"></span> Accounts <span class = "caret"></span></a>
					<ul class = "dropdown-menu">
						<li><a href = "admin.php"><span class = "glyphicon glyphicon-user"></span> Admin</a></li>
						<li><a href = "student.php"><span class = "glyphicon glyphicon-user"></span> Student</a></li>
						<li><a href = "faculty.php"><span class = "glyphicon glyphicon-user"></span> Faculty</a></li>
					</ul>
				</li>
				<li class = "bg-success">
					<a class = "dropdown-toggle" data-toggle = "dropdown" href = "#"><span class = "glyphicon glyphicon-cog"></span> Records <span class = "caret"></span></a>
					<ul class = "dropdown-menu">
						<li><a href = "record.php"><span class = "glyphicon glyphicon-book"></span> Students Entered</a></li>
						<li><a href = "record1.php"><span class = "glyphicon glyphicon-book"></span> Faculty Entered</a></li>
					</ul>
				</li>
			</ul>
			<br />
			<div class = "alert alert-success">Students Entered</div>
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
			<div class = "well col-lg-12">
				<table id = "table1" class = "table table-bordered">
					<thead class = "alert-info">
						<tr>
							<th>Student ID</th>
							<th>Student Name</th>
							<th>Time</th>
							<th>Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$q_time = $conn->query("SELECT * FROM `time` ") or die(mysqli_error());
							while($f_time = $q_time->fetch_array()){
						?>
						<tr>
							<td><?php echo $f_time['student_no']?></td>
							<td><?php echo ($f_time['student_name'])?></td>
							<td><?php echo date("h:i a", strtotime($f_time['time']))?></td>
							<td><?php echo date("m-d-Y", strtotime($f_time['date']))?></td>
							<td><button name = "<?php echo $f_time['time_id']?>" class = "btn btn-danger rtime_id" href = "#" data-toggle = "modal" data-target = "#delete"><span class = "glyphicon glyphicon-remove"></span></button></td>
						</tr>
					<?php
						}
					?>
					</tbody>
				</table>
			</br>
			<button class="pull-right btn-success btn btn-sm" onclick="ExportToExcel('xlsx')">Export</button>
			</div>
		</div>

	</body>
	<script src = "js/jquery.js"></script>
	<script src = "js/bootstrap.js"></script>
	<script src = "js/jquery.dataTables.js"></script>
	<script type = "text/javascript">
		$(document).ready(function(){
			$('#table1').DataTable();
		});
	</script>
	<script type = "text/javascript">
		$(document).ready(function(){
			$('.rtime_id').click(function(){
				$time_id = $(this).attr('name');
				$('.remove_id').click(function(){
					window.location = 'delete_time.php?time_id=' + $time_id;
				});
			});
		});
	</script>
	<script type="text/javascript">
	function ExportToExcel(type, fn, dl) {
		 var elt = document.getElementById('table1');
		 var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
		 return dl ?
			 XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
			 XLSX.writeFile(wb, fn || ('Attendance list.' + (type || 'xlsx')));
	}
	</script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

</html>
