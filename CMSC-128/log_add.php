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
                <!-- form title -->
                <div class="card-header">
                    <h2><span class="las la-users"></span> Add Student </h2>
                </div>

                <!-- add functionality -->
                <div class="card-body">
                    <?php
                        require 'functions.php';           
                        if(isset($_POST["log_add"])) {
                            // assigning forwarded data to variables
                            $log_id = $_POST['log_id'];
                            $tag_number = $_POST['tag_number'];
                            $student_number = $_POST['student_number'];
                            $time_in = $_POST['time_in'];
                            $time_out = $_POST['time_out'];
                            $state = $_POST['state'];

                            addChargingLog($log_id, $tag_number, $student_number, $time_in, $time_out, $state);
                        } else {
                            // form heading i
                            echo "<form action='log_add.php' target='_self' method='post'>";
                            echo "<table width='100%'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<td>LOG ID</td>";
                            echo "<td>Tag No.</td>";
                            echo "<td>Student No.</td>";
                            echo "</tr>";
                            echo "</thead>";
                        
                            // input fields i
                            echo "<tbody> <tr>";
                            echo "<td> <input type='text' id='log_id' name='log_id' value='0'/> </td>";
                            echo "<td> <input type='int' id='tag_number' name='tag_number' value='0'/> </td>";
                            echo "<td> <input type='text' id='student_number' name='student_number' value='XXXX-YYYYY'/> </td>";
                            echo "</tr>";

                            // form heading ii
                            echo "<tr>";
                            echo "<td>Time in</td>";
                            echo "<td>Time out</td>";
                            echo "<td>State</td>";
                            echo "</tr>";

                            // input fields ii
                            echo "<tr>";
                            echo "<td> <input type='text' id='time_in' name='time_in' value='YYYY-MM-DD HH:MM:SS'/> </td>";
                            echo "<td> <input type='text' id='time_out' name='time_out' value='YYYY-MM-DD HH:MM:SS'/> </td>";
                            echo "<td> <input type='text' id='state' name='state' value='active'/> </td>";
                            echo "</tr> </tbody>";
                            echo "</table>";

                            // forward data to self
                            echo "<br/><input type='submit' name='log_add' formmethod='post' value='Apply'>";
                            echo "</form>";
                        }
                    ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>