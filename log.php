<!DOCTYPE html>
<html lang="en">
    <head>
    <?php
        include 'includes/head.php'
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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
                            <h3><a id="reset" href='db-requests/reset_history.php'><span class='las la-redo'></span> Reset Charge History </a> </h3>
                        </div>

                        <!-- table content -->
                        <div class="card-body">
                            <table id="tableSort" width="100%">
                                <!-- table heading -->
                                <thead>
                                    <tr>
                                        <td>Action</td>
                                        <td>Log ID <span class='las la-sort'></td>
                                        <td>Tag No. <span class='las la-sort'></td>
                                        <td>Student No. <span class='las la-sort'></td>
                                        <td>Time-in <span class='las la-sort'></td>
                                        <td>Time-out <span class='las la-sort'></td>
                                        <td>State <span class='las la-sort'></td>
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
                                        echo "<td> <a class='edit' href='log_edit.php?
                                        log_id=".$row['log_id'].
                                        "&tag_number=".$row['tag_number'].
                                        "&student_number=".$row['student_number'].
                                        "&time_in=".$row['time_in'].
                                        "&time_out=".$row['time_out'].
                                        "&state=".$row['state'].
                                        "'><span class='las la-edit'></span></a></td>";
                                        echo "<td>".$row['log_id']."</td>";
                                        echo "<td>".$row['tag_number']."</td>";
                                        echo "<td>".$row['student_number']."</td>";
                                        echo "<td>".$row['time_in']."</td>";
                                        echo "<td>".$row['time_out']."</td>";
                                        echo "<td>".$log_state."</td>";
                                        
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
        <script src="assets/table-sort-script.js"></script>
        <script>
            $("#reset").click(function(event) {
                if (confirm("Are you sure you want to proceed to reset charging history?")) {
                    if (confirm("Are you sure you want to delete? Proceeding will delete all charging logs and current sessions.")) {
                } else {
                    event.preventDefault();
                    }
                } else {
                    event.preventDefault();
                }
            });
            $(".edit").click(function(event) {
            if (confirm("Are you sure you want to proceed to edit?")) {
            } else {
                event.preventDefault();
            }
            });
        </script>
    </body>
</html>