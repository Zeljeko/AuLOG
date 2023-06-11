<head>
<script src="https://cdn.jsdelivr.net/npm/chart.js" ></script>
        <script src="assets/chart-script.js"></script>
</head>

<div id="chart-container">
    <canvas id="collegeChart"></canvas>
</div>

<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'functions.php';

$allCollegesData = generateCollegeReport();


?>

<script>
    const allCollegesDataPie = <?php echo json_encode($allCollegesData); ?>;
    pieChart("collegeChart", allCollegesDataPie);
</script>