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
                
            <!-- sidebar label and charging log page title -->
            <h2>
                <label for="nav-toggle"> <span class="las la-bars"></span> </label>
                Charging Log
            </h2>
            
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

                        if(isset($_POST["log_edit"])) { // segment for processing edit transaction
                            // assigning received data to variables
                            $condition = $_POST['condition'];
                            $log_id = $_POST['log_id'];
                            $tag_number = $_POST['tag_number'];
                            $student_number = $_POST['student_number'];
                            $time_in = $_POST['time_in'];
                            $time_out = $_POST['time_out'];
                            $state = $_POST['state'];


                            // invoking edit function
                            editChargingLog($log_id, $tag_number, $student_number, $time_in, $time_out, $state, $condition);
                        } else { // segment for outputting form
                            // assigning received data to variables
                            $log_id = $_GET['log_id'];
                            $tag_number = $_GET['tag_number'];
                            $student_number = $_GET['student_number'];
                            $time_in = $_GET['time_in'];
                            $time_out = $_GET['time_out'];
                            $state = $_GET['state'];
                            
                            if($state == '0')
                                $log_state = "inactive";
                            else
                                $log_state = 'active';

                            // form heading i
                            echo "<form action='log_edit.php' target='_self' method='post'>";
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
                            echo "<td> <input type='text' id='log_id' name='log_id' value='".$log_id."'/> </td>";
                            echo "<td> <input type='int' id='tag_number' name='tag_number' value='".$tag_number."'/> </td>";
                            echo "<td> <input type='text' id='student_number' name='student_number' value='".$student_number."'/> </td>";
                            echo "</tr>";

                            // form heading ii
                            echo "<tr>";
                            echo "<td>Time in</td>";
                            echo "<td>Time out</td>";
                            echo "<td>State</td>";
                            echo "</tr>";

                            // input fields ii
                            echo "<tr>";
                            echo "<td> <input type='text' id='time_in' name='time_in' value='".$time_in."'/> </td>";
                            echo "<td> <input type='text' id='time_out' name='time_out' value='".$time_out."'/> </td>";
                            echo "<td> <input type='text' id='state' name='state' value='".$log_state."'/> </td>";
                            echo "</tr> </tbody>";
                            echo "</table>";

                            echo "<input type='hidden' id='condition' name='condition' value='".$log_id."'/>";

                            // forward data to self
                            echo "<br/><input type='submit' name='log_edit' formmethod='post' value='Apply'>";
                            echo "</form>";
                        }
                    ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>