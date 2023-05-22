<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPB AuLOG</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
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
                    <a href="main.php"><span class="las la-igloo"></span>
                    <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="admin.php" class="active"><span class="las la-users"></span>
                    <span>Admin</span></a>
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
            <div class="recent-grid Users card">
                <!-- Form Title -->
                <div class="card-header">
                    <h2><span class="las la-users"></span> Charging History </h2>
                </div>

                <!-- edit functionallity -->
                <div class="card-body">
                    <?php
                    require 'functions.php';

                    if(isset($_POST["log_edit"])) { // perform edit query
                        // assign forwarded data to variables
                        $condition = $_POST['condition'];
                        $log_id = $_POST['log_id'];
                        $tag_number = $_POST['tag_number'];
                        $student_number = $_POST['student_number'];
                        $time_in = $_POST['time_in'];
                        $time_out = $_POST['time_out'];
                        $state = $_POST['state'];


                        // update charging log
                        editChargingLog($log_id, $tag_number, $student_number, $time_in, $time_out, $state, $condition);
                    } else { // edit form
                        // assign received data to variables
                        $log_id = $_GET['log_id'];
                        $tag_number = $_GET['tag_number'];
                        $student_number = $_GET['student_number'];
                        $time_in = $_GET['time_in'];
                        $time_out = $_GET['time_out'];
                        $state = $_GET['state'];

                        // output edit form interface
                        editChargingLogForm($log_id, $tag_number, $student_number, $time_in, $time_out, $state);
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>