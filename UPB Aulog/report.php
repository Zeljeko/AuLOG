<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>UPB AuLOG</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <link rel="stylesheet" href="style.css">

        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js" ></script>
        <script src="chart-script.js"></script>
        <!-- DO NOT CHANGE ORDERING of the two lines above this -->

    </head>

    <body>
        
        <!-- sidebar toggle -->
        <input type="checkbox" id="nav-toggle">

        <!-- sidebar -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <h2><span class="lab la-accusoft"></span> <span>AuLOG</span></h2>
            </div>

            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="main.php" ><span class="las la-igloo"></span>
                        <span>Dashboard</span></a>
                    </li>
                    <li>
                        <a href="admin.php"><span class="las la-users"></span>
                        <span>Admin</span></a>
                    </li>
                    <li>
                        <a href="report.php" class="active"><span class="las la-users"></span>
                        <span>Report</span></a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- main content -->
        <div class="main-content">

            <!-- navigation bar -->
            <header>
                <!-- sidebar label and main page title -->
                <h2>
                    <label for="nav-toggle"> <span class="las la-bars"></span> </label>
                    Dashboard
                </h2>

                <!-- searchbar -->
                <div class="search-wrapper">
                    <span class="las la-search"></span>
                    <input type="search" placeholder="Search here" />
                </div>
                
                <!-- site logo -->
                <div class="logo-wrapper">
                    <h4>UP Baguio Library</h4>
                    <small>Admin</small>
                </div>
            </header>

            <!-- primary content -->
            <main>
                <?php
                    require_once 'functions.php';

                    $dailyData = generateDailyReport();
                    $weeklyData = generateWeeklyReport();
                    $monthlyData = generateMonthlyReport();
                ?>
                <h1>All Students</h1>
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

                <h1>Social Sciences</h1>
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

                <h1>Science</h1>
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

                <script>
                const dailyData = <?php echo json_encode($dailyData); ?>;
                dailyChart(dailyData);
                const weeklyData = <?php echo json_encode($weeklyData); ?>;
                weeklyChart(weeklyData);
                const monthlyData = <?php echo json_encode($monthlyData); ?>;
                monthlyChart(monthlyData);
                </script>
            <main>
        </div>
    </body>
</html>