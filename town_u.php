<?php 
require_once "config.php";

// Updated Query for chart data using dOwned and dVacc
$sql_query = "SELECT t.dTown, 
                     SUM(r.dOwned) AS dog_count, 
                     SUM(r.dVacc) AS vaccinated_count
              FROM tblreg r
              JOIN towns t ON r.dTownID = t.id
              GROUP BY t.dTown";

$towns = [];
$dog_counts = [];
$vaccinated_counts = [];
$non_vaccinated_counts = [];

if ($result = $conn->query($sql_query)) {
    while ($row = $result->fetch_assoc()) {
        $towns[] = $row['dTown'];
        $dog_counts[] = $row['dog_count'];
        $vaccinated_counts[] = $row['vaccinated_count'];
        $non_vaccinated_counts[] = $row['dog_count'] - $row['vaccinated_count'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dog Vaccination Charts</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/loader.js"></script>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            // Pie Chart
            var pieData = google.visualization.arrayToDataTable([
                ['Status', 'Count'],
                ['Vaccinated', <?php echo array_sum($vaccinated_counts); ?>],
                ['Non-Vaccinated', <?php echo array_sum($non_vaccinated_counts); ?>]
            ]);

            var pieOptions = {
                title: 'Vaccination Status of Registered Dogs',
                is3D: true,
                slices: {
                    0: { color: '#28a745' },
                    1: { color: '#dc3545' }
                }
            };

            var pieChart = new google.visualization.PieChart(document.getElementById('piechart'));
            pieChart.draw(pieData, pieOptions);

            // Bar Chart
            var barData = google.visualization.arrayToDataTable([
                ['Town', 'Registered Dogs', 'Vaccinated Dogs'],
                <?php 
                for ($i = 0; $i < count($towns); $i++) {
                    echo "['" . addslashes($towns[$i]) . "', " . $dog_counts[$i] . ", " . $vaccinated_counts[$i] . "],";
                }
                ?>
            ]);

            var barOptions = {
                title: 'Dog Registration & Vaccination Per Town',
                chartArea: {width: '50%'},
                hAxis: {title: 'Number of Dogs', minValue: 0},
                vAxis: {title: 'Towns'},
                bars: 'horizontal',
                colors: ['#007bff', '#28a745']
            };

            var barChart = new google.visualization.BarChart(document.getElementById('barchart'));
            barChart.draw(barData, barOptions);
        }
    </script>
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">Dog Vaccination Charts</h2>
        
        <!-- Pie Chart -->
        <div class="row mb-4">
            <div class="col-md-6 offset-md-3">
                <div id="piechart" style="width: 100%; height: 400px;"></div>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="row">
            <div class="col-md-12">
                <div id="barchart" style="width: 100%; height: 500px;"></div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="home.html" class="btn btn-primary">Back to Home</a>
        </div>
    </div>
</body>
</html>
