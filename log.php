<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include 'includes/head.php'
        ?>
    </head>
    <body>
        <?php
            $page = 'log';
            include 'includes/sidebars.php'
        ?>

        <!-- main content -->
        <div class="main-content">
            <!-- navigation bar -->
            <?php
            $page = 'log';
            include 'includes/header.php'
            ?>
            <!-- primary content -->
            <main>
                <div class="recent-grid">
                    <div class="Users card">
                        <!-- table title -->
                        <div class="card-header">
                            <h2><span class="las la-battery-full"></span> Charging Entries </h2>
                            <h3><a href='db-requests/reset_history.php'><span class='las la-redo'></span> Reset Charge History </a> </h3>
                        </div>

                        <!-- table content -->
                        <div class="card-body">
                            <table width="100%">
                                <!-- table heading -->
                                <thead>
                                    <tr>
                                        <td>Log ID</td>
                                        <td>Tag No.</td>
                                        <td>Student No.</td>
                                        <td>Time-in</td>
                                        <td>Time-out</td>
                                        <td>State</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>

                                <!-- table body -->
                                <tbody>
                                <?php
                                    require 'functions.php';

                                    if(isset($_POST["log"])) 
                                        $result = getStudentLog($_POST['student_number']); // student charging log
                                    else 
                                        $result = getChargingLog(); // all charging logs

                                    // output charging logs
                                    foreach($result AS $row) {
                                        $log_state = NULL;
                                        
                                        if($row['state'] == '0')
                                            $log_state = "inactive";
                                        elseif($row['state'] == '1')
                                            $log_state = 'active';
                                        
                                        if($log_state == NULL)
                                            continue;

                                        echo "<tr>";
                                        echo "<td>".$row['log_id']."</td>";
                                        echo "<td>".$row['tag_number']."</td>";
                                        echo "<td>".$row['student_number']."</td>";
                                        echo "<td>".$row['time_in']."</td>";
                                        echo "<td>".$row['time_out']."</td>";
                                        echo "<td>".$log_state."</td>";
                                        echo "<td> <a class='edit' href='log_edit.php?
                                        log_id=".$row['log_id'].
                                        "&tag_number=".$row['tag_number'].
                                        "&student_number=".$row['student_number'].
                                        "&time_in=".$row['time_in'].
                                        "&time_out=".$row['time_out'].
                                        "&state=".$row['state'].
                                        "'><span class='las la-edit'></span></a></td>";
                                        echo "</tr>";
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>