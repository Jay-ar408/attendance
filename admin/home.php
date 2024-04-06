<!DOCTYPE html>
<?php
if (isset($_GET['filter_date'])) {
	$filter_date = $_GET['filter_date']; // This will be in the format 'YYYY-MM'

	// Connect to the database
	$conn = mysqli_connect("localhost", "root", "", "db_sars");

	// Construct your SQL query with the selected year and month
	$query = "SELECT s.course, c.acro, COUNT(s.student_no) AS number
	FROM student s 
	INNER JOIN time t ON s.student_no = t.student_no 
	INNER JOIN course c ON s.course = c.course
	WHERE DATE_FORMAT(t.date, '%Y-%m') = '$filter_date'
	GROUP BY s.course";

	$query2 = "SELECT DATE_FORMAT(t.date, '%M %Y') AS monthYear
	FROM student s
	INNER JOIN time t ON s.student_no = t.student_no
	INNER JOIN course c ON s.course = c.course
	WHERE DATE_FORMAT(t.date, '%Y-%m') = '$filter_date'
	GROUP BY s.course
	LIMIT 1;
	";

	$result = mysqli_query($conn, $query);
	$result2 = mysqli_query($conn, $query2);

	$data = [];

	while ($row = mysqli_fetch_assoc($result)) {
		$data[] = [$row['acro'], (int) $row['number']];
	}

	$monthdata = $result2 ? mysqli_fetch_assoc($result2)['monthYear'] : null;



	// Close the database connection
	mysqli_close($conn);
}
?>

<?php

require_once 'validator.php';
require_once 'account.php';
?>
<html lang="eng">

<head>
	<title>ISU Ilagan Library</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="css/bootstrap.css" />
	<link rel="shortcut icon" type="img/png" href="images/isulogo.png">
</head>

<body>
	<nav class="navbar bg-success navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="home.php"><img src="images/isulogo.png" class="pull-left" width="50px" height="50px"></a>
				<p class="navbar-text">ISU Ilagan Library</p>
			</div>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i>
						<?php echo htmlentities($admin_name) ?> <b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="logout.php"><i class="glyphicon glyphicon-off"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
	<div class="container-fluid" style="margin-top:70px;">


		<ul class="nav nav-pills">

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
			<span id='ct6' class="pull-right" style="font-size:23px"></span>

			<li class="bg-success"><a href="home.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-cog"></span>
					Accounts <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="admin.php"><span class="glyphicon glyphicon-user"></span> Admin</a></li>
					<li><a href="student.php"><span class="glyphicon glyphicon-user"></span> Student</a></li>
					<li><a href="faculty.php"><span class="glyphicon glyphicon-user"></span> Faculty</a></li>
				</ul>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-cog"></span>
					Records <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="record.php"><span class="glyphicon glyphicon-book"></span> Students Entered</a></li>
					<li><a href="record1.php"><span class="glyphicon glyphicon-book"></span> Faculty Entered</a></li>
				</ul>
			</li>
		</ul>
		<br />
		<div class="alert bg-success">Home</div>
	</div>

	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
	<div class="container bootstrap snippet pull-centered">
		<div class="row">

			<div class="col-md-3 col-sm-4">
				<div class="circle-tile ">
					<a href="student.php">
						<div class="circle-tile-heading blue"><i class="fa fa-users fa-fw fa-3x"></i></div>
					</a>
					<div class="circle-tile-content blue">
						<div class="circle-tile-description text-faded"> Total Students Registered </div>
						<?php
						$dash_user_query = "SELECT * from student";
						$dash_user_query_run = mysqli_query($conn, $dash_user_query);

						if ($user_total = mysqli_num_rows($dash_user_query_run)) {
							echo '<h3 class ="mb-0 ">' . $user_total . '</h3>';
						} else {
							echo '<h3 class="mb-0">0</h3>';
						}
						?>
						<a class="circle-tile-footer" href="student.php">More Info<i
								class="fa fa-chevron-circle-right"></i></a>

					</div>
				</div>
			</div>

			<div class="col-md-3 col-sm-4">
				<div class="circle-tile ">
					<a href="faculty.php">
						<div class="circle-tile-heading orange"><i class="fa fa-users fa-fw fa-3x"></i></div>
					</a>
					<div class="circle-tile-content orange">
						<div class="circle-tile-description text-faded"> Total Faculty Registered </div>
						<?php
						$dash_user_query = "SELECT * from faculty";
						$dash_user_query_run = mysqli_query($conn, $dash_user_query);

						if ($user_total = mysqli_num_rows($dash_user_query_run)) {
							echo '<h3 class ="mb-0 ">' . $user_total . '</h3>';
						} else {
							echo '<h3 class="mb-0">0</h3>';
						}
						?>
						<a class="circle-tile-footer" href="faculty.php">More Info<i
								class="fa fa-chevron-circle-right"></i></a>

					</div>
				</div>
			</div>

			<div class="col-md-3 col-sm-4">
				<div class="circle-tile ">
					<a href="record.php">
						<div class="circle-tile-heading red"><i class="fa fa-users fa-fw fa-3x"></i></div>
					</a>
					<div class="circle-tile-content red">
						<div class="circle-tile-description text-faded"> Total Students Entered </div>
						<?php
						$dash_user_query = "SELECT * from time";
						$dash_user_query_run = mysqli_query($conn, $dash_user_query);

						if ($user_total = mysqli_num_rows($dash_user_query_run)) {
							echo '<h3 class ="mb-0 ">' . $user_total . '</h3>';
						} else {
							echo '<h3 class="mb-0">0</h3>';
						}
						?>
						<a class="circle-tile-footer" href="record.php">More Info<i
								class="fa fa-chevron-circle-right"></i></a>

					</div>
				</div>
			</div>

			<div class="col-md-3 col-sm-4">
				<div class="circle-tile ">
					<a href="record1.php">
						<div class="circle-tile-heading green"><i class="fa fa-users fa-fw fa-3x"></i></div>
					</a>
					<div class="circle-tile-content green">
						<div class="circle-tile-description text-faded"> Total Faculty Entered</div>
						<?php
						$dash_user_query = "SELECT * from timef";
						$dash_user_query_run = mysqli_query($conn, $dash_user_query);

						if ($user_total = mysqli_num_rows($dash_user_query_run)) {
							echo '<h3 class ="mb-0 ">' . $user_total . '</h3>';
						} else {
							echo '<h3 class="mb-0">0</h3>';
						}
						?>
						<a class="circle-tile-footer" href="record1.php">More Info<i
								class="fa fa-chevron-circle-right"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<style>
		.circle-tile {
			margin-bottom: 15px;
			text-align: center;
		}

		.circle-tile-heading {
			border: 3px solid rgba(255, 255, 255, 0.3);
			border-radius: 100%;
			color: #FFFFFF;
			height: 80px;
			margin: 0 auto -40px;
			position: relative;
			transition: all 0.3s ease-in-out 0s;
			width: 80px;
		}

		.circle-tile-heading .fa {
			line-height: 80px;
		}

		.circle-tile-content {
			padding-top: 50px;
		}

		.circle-tile-number {
			font-size: 26px;
			font-weight: 700;
			line-height: 1;
			padding: 5px 0 15px;
		}

		.circle-tile-description {
			text-transform: uppercase;
		}

		.circle-tile-footer {
			background-color: rgba(0, 0, 0, 0.1);
			color: rgba(255, 255, 255, 0.5);
			display: block;
			padding: 5px;
			transition: all 0.3s ease-in-out 0s;
		}

		.circle-tile-footer:hover {
			background-color: rgba(0, 0, 0, 0.2);
			color: rgba(255, 255, 255, 0.5);
			text-decoration: none;
		}

		.circle-tile-heading.dark-blue:hover {
			background-color: #2E4154;
		}

		.circle-tile-heading.green:hover {
			background-color: #138F77;
		}

		.circle-tile-heading.orange:hover {
			background-color: #DA8C10;
		}

		.circle-tile-heading.blue:hover {
			background-color: #2473A6;
		}

		.circle-tile-heading.red:hover {
			background-color: #CF4435;
		}

		.circle-tile-heading.purple:hover {
			background-color: #7F3D9B;
		}

		.tile-img {
			text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.9);
		}

		.dark-blue {
			background-color: #34495E;
		}

		.green {
			background-color: #109618;
		}

		.blue {
			background-color: #2980B9;
		}

		.orange {
			background-color: #F39C12;
		}

		.red {
			background-color: #E74C3C;
		}

		.purple {
			background-color: #8E44AD;
		}

		.dark-gray {
			background-color: #7F8C8D;
		}

		.gray {
			background-color: #95A5A6;
		}

		.light-gray {
			background-color: #BDC3C7;
		}

		.yellow {
			background-color: #F1C40F;
		}

		.text-dark-blue {
			color: #34495E;
		}

		.text-green {
			color: #16A085;
		}

		.text-blue {
			color: #2980B9;
		}

		.text-orange {
			color: #F39C12;
		}

		.text-red {
			color: #E74C3C;
		}

		.text-purple {
			color: #8E44AD;
		}

		.text-faded {
			color: rgba(255, 255, 255, 0.7);
		}
	</style>


	<!-- //todo ================= FILTER FOR MONTHLY REPORT START =================  -->

	<!-- <div class="form-group" style="margin-top: 25px">
		<form action="home.php" method="GET"
			style="display: flex; justify-content: center; flex-direction: column; align-items: center">
			<label for="filter_date">Filter by Year and Month:</label>
			<input type="month" name="filter_date" required="required" class="form-control" style="width: 20%" />
			<button type="submit" class="btn btn-primary" style="margin-top: 5px">Apply</button>
		</form>
	</div> -->

	<div class="form-group" style="margin-top: 25px">
		<form action="home.php" method="GET"
			style="display: flex; justify-content: center; flex-direction: column; align-items: center">
			<label for="filter_date">Filter by Year and Month:</label>
			<?php
			// Generate the default value as the current year and month
			$currentYearMonth = date('Y-m');
			?>
			<input type="month" name="filter_date" required="required" class="form-control" style="width: 20%"
				value="<?php echo $currentYearMonth; ?>">
			<button type="submit" class="btn btn-primary" style="margin-top: 5px">Apply</button>
		</form>
	</div>




	<!-- //todo  ================= FILTER FOR MONTHLY REPORT END =================  -->

	<head>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
			google.charts.load('current', { 'packages': ['corechart'] });
			google.charts.setOnLoadCallback(drawCharts);

			function drawCharts() {
				var data = new google.visualization.DataTable();
				data.addColumn('string', 'Course');
				data.addColumn('number', 'Number of Students');
				data.addRows(<?php echo json_encode($data); ?>);

				var numCourses = <?php echo count($data); ?>;
				var colors = generateColors(numCourses);

				function generateColors(num) {
					var colorPalette = ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#fb7185', '#ec4899', '#581c87', '#083344', '#93c5fd', '#34d399', '#713f12', '#3730a3', '#a855f7'];
					var colors = [];
					for (var i = 0; i < num; i++) {
						colors.push(colorPalette[i % colorPalette.length]);
					}
					return colors;
				}

				// var pieOptions = {
				// 	title: 'Number of Students per Course',
				// 	is3D: true,
				// 	pieHole: 0.4,
				// 	colors: colors,
				// 	legend: { position: 'right' },
				// 	pieSliceText: 'value',
				// 	pieSliceTextStyle: { color: 'white', fontSize: 14 },
				// 	chartArea: { width: '100%', height: '80%' }
				// };
				var options = {
					title: 'Number of Students per Course',
					is3D: true,
					chartArea: { width: '100%', height: '80%' }
				};

				var chart = new google.visualization.PieChart(
					document.getElementById("pie_chart_div")
				);
				chart.draw(data, options);



				// var pieChart = new google.visualization.PieChart(document.getElementById('pie_chart_div'));
				// pieChart.draw(data, pieOptions);


				var columnOptions = {
					title: 'Number of Students per Course',
					colors: colors,
					legend: { position: 'none' },
					chartArea: { width: '100%', height: '80%' }
				};

				var columnChart = new google.visualization.ColumnChart(document.getElementById('column_chart_div'));
				columnChart.draw(data, columnOptions);
			}








			function printCharts() {
				var printWindow = window.open('', '');
				printWindow.document.open();
				printWindow.document.write('<html><head><title>Print Charts</title></head><body>');
				printWindow.document.write('<h2>Courses of Students Using the Library (<span><?= $monthdata ?></span>)</h2>');
				printWindow.document.write('<div  style="margin-bottom: 25px;">');
				printWindow.document.write(document.getElementById('mytable').innerHTML);
				printWindow.document.write('</div>');

				printWindow.document.write(document.getElementById('pie_chart_div').innerHTML);

				printWindow.document.write(document.getElementById('column_chart_div').innerHTML);

				printWindow.document.write('</body></html>');
				printWindow.document.close();
				printWindow.print();
			}


		</script>

		<style>
			body {
				background-color: #f2f2f2;
				font-family: Arial, sans-serif;
			}

			.chart {
				background-color: #fff;
				border-radius: 8px;
				box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);

			}

			.chart-container {

				margin-bottom: 30px;
				padding: 20px;
				display: inline-block;
			}


			h2 {
				color: #333;
			}
		</style>
	</head>

	<body>
		<div style="text-align: center; padding: 20px;">
			<h2 style="color: #333; font-size: 24px; margin-bottom: 20px;">
				Courses of Students Using the Library
				(<span>
					<?= $monthdata ?>
				</span>)
			</h2>

			<div id="mytable" style="display: flex; justify-content: center; align-items: center; margin-bottom: 25px;">
				<!-- <table id="bar-table" border="1" style="width: 100%; max-width: 1000px">
					<tr>
						<th style="text-align: center;">Course Acronym</th>
						<th style="text-align: center;">Course Description</th>
						<th style="text-align: center;">Student total</th>
					</tr>
					<tr>
						<td>16</td>
						<td>Master of Arts in Education-Major in Educational Management</td>
						<td>14</td>

					</tr>
				</table> -->

				<style>
					table {
						width: 100%;
						max-width: 1000px;

						border-collapse: collapse;
						margin: 0 auto;
					}

					th,
					td {
						border: 1px solid #ccc;
						padding: 8px;
						text-align: center;
					}

					th:nth-child(2),
					td:nth-child(2) {
						width: 700px;
						/* Adjust the width as needed */
					}


					th {
						background-color: #e4e4e7;
						/* Background color for <th> elements */
					}


					.tdata:hover {
						background-color: #cbd5e1;
					}
				</style>

				<table>
					<thead>
						<tr>
							<th scope="col">Course</th>
							<th scope="col">Description</th>
							<th scope="col">Total Student</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (mysqli_num_rows($result) > 0) { ?>
							<?php foreach ($result as $sdata): ?>
								<tr class="tdata">
									<td>
										<?= $sdata['acro'] ?>
									</td>
									<td>
										<?= $sdata['course'] ?>
									</td>
									<td>
										<?= $sdata['number'] ?>
									</td>
								</tr>



							<?php endforeach; ?>
							<?php
						} else {
							?>
							<tr>
								<td>No Record found</td>
							</tr>

							<?php
						}
						?>



					</tbody>
				</table>







			</div>

			<div class="chart chart-container" id="pie_chart_div" style="width: 1000px; height: 450px;">
			</div>






			<div class="chart chart-container" id="column_chart_div" style="width: 1000px; height: 408px;">

			</div>



			<button onclick="printCharts()" class="centered"
				style="padding: 10px 120px; font-size: 16px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
				Print chart
			</button>
		</div>
		<style media="screen">
			.centered {
				display: block;
				margin: 0 auto;
			}
		</style>
	</body>




</body>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>

</html>