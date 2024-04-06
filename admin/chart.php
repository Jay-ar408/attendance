<?php
require_once 'validator.php';
require_once 'account.php';

if (isset($_GET['filter_date'])) {
    $filter_date = $_GET['filter_date']; // This will be in the format 'YYYY-MM'

    // Connect to the database
    $conn = mysqli_connect("localhost", "root", "", "db_sars");

    // Construct your SQL query with the selected year and month
    $query = "SELECT s.course, COUNT(s.student_no) AS number
              FROM student s 
              INNER JOIN time t ON s.student_no = t.student_no 
              WHERE DATE_FORMAT(t.date, '%Y-%m') = '$filter_date'
              GROUP BY s.course";

    $result = mysqli_query($conn, $query);

    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [$row['course'], (int) $row['number']];
    }

    // Close the database connection
    mysqli_close($conn);
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div style="text-align: center; padding: 20px;">
        <h2 style="color: #333; font-size: 24px; margin-bottom: 20px;">Courses of Students Using the Library</h2>

        <div class="chart-container" id="pie_chart_div" style="width: 1000px; height: 450px;"></div>
        <button onclick="printCharts()" class="centered"
            style="margin-bottom: 25px; padding: 10px 120px; font-size: 16px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Print Pie chart
        </button>

        <div class="chart-container" id="column_chart_div" style="width: 1000px; height: 408px;"></div>
        <button onclick="printBarCharts()" class="centered"
            style="padding: 10px 120px; font-size: 16px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Print Bar chart
        </button>
    </div>
    <div class="form-group" style="margin-top: 25px">
        <form action="chart.php" method="GET"
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
            printWindow.document.write('<h2>Courses of Students Using the Library</h2>');
            printWindow.document.write('<div class="chart-container" style="width: 600px; height: 600px;">');
            printWindow.document.write(document.getElementById('pie_chart_div').innerHTML);

            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }



        function printBarCharts() {
            var printWindow = window.open('', '');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>Print Charts</title></head><body>');
            printWindow.document.write('<h2>Courses of Students Using the Library</h2>');
            printWindow.document.write('<div class="chart-container" style="width: 600px; height: 400px;">');
            printWindow.document.write(document.getElementById('column_chart_div').innerHTML);
            printWindow.document.write('</div>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }

    </script>

</body>

</html>