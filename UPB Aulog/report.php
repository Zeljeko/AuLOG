[<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include 'includes/head.php'
        ?>

        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js" ></script>
        <script src="assets/chart-script.js"></script>
        <!-- DO NOT CHANGE ORDERING of the two lines above this -->

    </head>

    <body>
        
        <?php
        $page = 'reports';
        include 'includes/sidebars.php'
        ?>

        <!-- main content -->
        <div class="main-content">

            <!-- navigation bar -->
            <?php
            $page = 'reports';
            include 'includes/header.php'
            ?>

            <!-- primary content -->
            <main>
                <div class="recent-grid Users card">
                <?php
                    require_once 'functions.php';

                    $dailyData = generateDailyReport();
                    $weeklyData = generateWeeklyReport();
                    $monthlyData = generateMonthlyReport();

                    $dailyDataCS = generateDailyReportCollege('CS');
                    $weeklyDataCS = generateWeeklyReportCollege('CS');
                    $monthlyDataCS = generateMonthlyReportCollege('CS');

                    $dailyDataCSS = generateDailyReportCollege('CSS');
                    $weeklyDataCSS = generateWeeklyReportCollege('CSS');
                    $monthlyDataCSS = generateMonthlyReportCollege('CSS');

                    $dailyDataCAC = generateDailyReportCollege('CAC');
                    $weeklyDataCAC = generateWeeklyReportCollege('CAC');
                    $monthlyDataCAC = generateMonthlyReportCollege('CAC');
                    
                    
                ?>

                <h1 id='chart-header'>All Students</h1>
                <div id = "chart-chart-container">
                    <div id="chart-container">
                        <canvas id="dailyChart"></canvas>
                    </div>
                    <div id="chart-container">
                        <canvas id="weeklyChart"></canvas>
                    </div>
                    <div id="chart-container">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>

                <h1 id='chart-header'>Science</h1>
                <div id = "chart-chart-container">
                    <div id="chart-container">
                        <canvas id="dailyChartCS"></canvas>
                    </div>
                    <div id="chart-container">
                        <canvas id="weeklyChartCS"></canvas>
                    </div>
                    <div id="chart-container">
                        <canvas id="monthlyChartCS"></canvas>
                    </div>
                </div>

                <h1 id='chart-header'>Social Sciences</h1>
                <div id = "chart-chart-container">
                    <div id="chart-container">
                        <canvas id="dailyChartCSS"></canvas>
                    </div>
                    <div id="chart-container">
                        <canvas id="weeklyChartCSS"></canvas>
                    </div>
                    <div id="chart-container">
                        <canvas id="monthlyChartCSS"></canvas>
                    </div>
                </div>

                <h1 id='chart-header'>Arts and Communication</h1>
                <div id = "chart-chart-container">
                    <div id="chart-container">
                        <canvas id="dailyChartCAC"></canvas>
                    </div>
                    <div id="chart-container">
                        <canvas id="weeklyChartCAC"></canvas>
                    </div>
                    <div id="chart-container">
                        <canvas id="monthlyChartCAC"></canvas>
                    </div>
                </div>


                <script>
                const dailyData = <?php echo json_encode($dailyData); ?>;
                dailyChart("dailyChart", dailyData);
                const weeklyData = <?php echo json_encode($weeklyData); ?>;
                weeklyChart("weeklyChart", weeklyData);
                const monthlyData = <?php echo json_encode($monthlyData); ?>;
                monthlyChart("monthlyChart", monthlyData);

                const dailyDataCS = <?php echo json_encode($dailyDataCS); ?>;
                dailyChart("dailyChartCS", dailyDataCS);
                const weeklyDataCS = <?php echo json_encode($weeklyDataCS); ?>;
                weeklyChart("weeklyChartCS", weeklyDataCS);
                const monthlyDataCS = <?php echo json_encode($monthlyDataCS); ?>;
                monthlyChart("monthlyChartCS", monthlyDataCS);

                const dailyDataCSS = <?php echo json_encode($dailyDataCSS); ?>;
                dailyChart("dailyChartCSS", dailyDataCSS);
                const weeklyDataCSS = <?php echo json_encode($weeklyDataCSS); ?>;
                weeklyChart("weeklyChartCSS", weeklyDataCSS);
                const monthlyDataCSS = <?php echo json_encode($monthlyDataCSS); ?>;
                monthlyChart("monthlyChartCSS", monthlyDataCSS);
                
                const dailyDataCAC = <?php echo json_encode($dailyDataCAC); ?>;
                dailyChart("dailyChartCAC", dailyDataCAC);
                const weeklyDataCAC = <?php echo json_encode($weeklyDataCAC); ?>;
                weeklyChart("weeklyChartCAC", weeklyDataCAC)
                const monthlyDataCAC = <?php echo json_encode($monthlyDataCAC); ?>;
                monthlyChart("monthlyChartCAC", monthlyDataCAC);


                </script>
                </div>
            <main>
        </div>
    </body>
</html>