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
        $page = 'main';
        include 'includes/sidebars.php'
        ?>

        <!-- main content -->
        <div class="main-content">

            <!-- header -->
            <?php
            $page = 'main';
            include 'includes/header.php'
            ?>

            <!-- primary content -->
            <main>

                <!-- active user count -->
                <div class="cards">
                    <div class="card-single" id = "active-number">
                    <?php
                        require 'functions.php';
                        $result = getActiveStudents();
                            echo "<h1>".count($result)."</h1><h1> currently active </h1>";
                    ?>
                    </div>
                    <div class="card-single">
                        <form class="form-input" id="rfid_form" action='db-requests/start_charging_session.php' method='post'>
                            <div class="input-wrapper">
                                <input class="field_input" type = 'text' id = 'field_input' placeholder ="Place your ID onto the scanner">
                                <input class="field_sn" type = 'text' id = 'student_number' name = 'student_number'>
                                <input class="field_rfid" type = 'text' id = 'rfid_tag' name = 'rfid_tag'/>
                                
                                <select class="tag_number" id = 'tag_number' name = 'tag_number'>
                                <?php
                                    $number_of_tags = getNumberOfTags();

                                    $tag_number = 1;
                                    while($tag_number <= $number_of_tags) {
                                        echo "<option value = '".$tag_number."'>".$tag_number."</option>";
                                        $tag_number = $tag_number + 1;
                                    }


                                ?>
                                </select>
                                <button id="id_submit" name='start_charging_session' formmethod='post'> <span class="las la-share"></span></button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- table of active users -->
                <div class="recent-grid Users card">
                    <!-- table title -->
                    <div class="card-header">
                        <h2><span class="las la-users"></span> Users</h2>
                    </div>

                    <!-- table content -->
                    <div class="card-body" id = "active-students">
                        <table width="100%" id = "active-table">
                            <!-- table heading -->
                            <thead>
                                <tr>
                                    <td>Action</td>
                                    <td>Tag No. </td>
                                    <td>RFID Tag</td>
                                    <td>Name</td>
                                    <td>College</td>
                                    <td>Remaining Charge</td>
                                    <td>Time Elapsed</td>
                                </tr>
                            </thead>
  
                            <tbody> 
                                <?php
                                    $result = getActiveStudents();

                                    // displaying student entries
                                    foreach($result AS $row) {     
                                        $hours = intdiv(getRemainingCharge($row['student_number']), 60);
                                        $minutes = getRemainingCharge($row['student_number']) % 60;
                                        
                                        $hours_elapsed = intdiv(getTimeElapsed($row['log_id']), 60);
                                        $minutes_elapsed = getTimeElapsed($row['log_id']) % 60;

                                        echo "<tr>";
                                        echo "<td> <a class='edit' href='tag_edit.php?log_id=".$row['log_id'].
                                            "&student_number=".$row['student_number'].
                                            "&tag_number=".$row['tag_number'].
                                            "'> <span class='las la-edit'></span></a> 
                                            
                                            <a class='end' href='db-requests/end_charging_session.php?
                                            student_number=".$row['student_number'].
                                            "&log_id=".$row['log_id'].
                                            "&time_in=".$row['time_in']."'> <span class='las la-undo'></span></a>
                                            
                                            </td>";
                                        echo "<td>".$row['tag_number']."</td>";
                                        echo "<td>".$row['rfid_tag']."</td>";
                                        echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
                                        echo "<td>".$row['college']."</td>";
                                        echo "<td>".$hours." hours ".$minutes." minutes</td>";
                                        echo "<td>".$hours_elapsed." hours ".$minutes_elapsed." minutes</td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
        <script src="assets/script.js"></script>
    </body>
</html>