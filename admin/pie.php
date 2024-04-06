<?php
$conn = mysqli_connect("localhost", "root", "", "db_sars");
$query = "SELECT course, COUNT(*) as number FROM student GROUP BY course";
$result = mysqli_query($conn, $query);
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [$row['course'], (int) $row['number']];
}
mysqli_close($conn);
?>

<html>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Course');
            data.addColumn('number', 'Number of Students');
            data.addRows(<?php echo json_encode($data); ?>);

            var numCourses = <?php echo count($data); ?>;
            var colors = generateColors(numCourses);

            function generateColors(num) {
                var colorPalette = ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099'];
                var colors = [];
                for (var i = 0; i < num; i++) {
                    colors.push(colorPalette[i % colorPalette.length]);
                }
                return colors;
            }

            var pieOptions = {
                title: 'Number of Students per Course',
                is3D: true,
                pieHole: 0.4,
                colors: colors,
                legend: {position: 'right'},
                pieSliceText: 'value',
                pieSliceTextStyle: {color: 'white', fontSize: 14},
                chartArea: {width: '80%', height: '80%'}
            };

            var columnOptions = {
                title: 'Number of Students per Course',
                colors: colors,
                legend: {position: 'none'},
                chartArea: {width: '80%', height: '80%'}
            };

            var pieChart = new google.visualization.PieChart(document.getElementById('pie_chart_div'));
            pieChart.draw(data, pieOptions);

            var columnChart = new google.visualization.ColumnChart(document.getElementById('column_chart_div'));
            columnChart.draw(data, columnOptions);
        }
    </script>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        .chart-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
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
    <div style="text-align: center;">
        <h2>Courses of Students Using the Library</h2>
        <div class="chart-container" id="pie_chart_div" style="width: 800px; height: 500px;"></div>
        <div class="chart-container" id="column_chart_div" style="width: 800px; height: 500px;"></div>
    </div>
</body>
</html>
