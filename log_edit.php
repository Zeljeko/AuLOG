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
                <div class="recent-grid Users card">
                    <!-- Form Title -->
                    <div class="card-header">
                        <h2><span class="las la-battery-full"></span> Edit Charging Log </h2>
                        <h3><a href='log.php'>Return</a></h3>
                    </div>

                    <!-- edit functionallity -->
                    <div class="card-body formfield">
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

                                echo "<form action='log_edit.php' target='_self' method='post'>";
                                echo "<div>";
                                echo "<label for='log_id'>Log ID</label>";
                                echo "<div class='input-wrapper'>";
                                echo "<span class='las la-hashtag'></span>";
                                echo "<input type='text' id='log_id' name='log_id' placeholder='Log ID' value='".$log_id."'/>";
                                echo "</div>";
                                echo "</div>";

                                echo "<div>";
                                echo "<label for='tag_number'>Tag Number</label>";
                                echo "<div class='input-wrapper'>";
                                echo "<span class='las la-address-card'></span>";
                                echo "<input type='int' id='tag_number' name='tag_number' placeholder='Log ID' maxlength='2' value='".$tag_number."'/>";
                                echo "</div>";
                                echo "</div>";
                                
                                echo "<div>";
                                echo "<label for='student_number'>Student Number</label>";
                                echo "<div class='input-wrapper'>";
                                echo "<span class='las la-user'></span>";
                                echo "<input type='text' id='student_number' name='student_number' placeholder='xxxx-xxxxx' value='".$student_number."'/>";
                                echo "</div>";
                                echo "</div>";
                                
                                echo "<div>";
                                echo "<label for='time_in'>Time Logged In</label>";
                                echo "<div class='input-wrapper'>";
                                echo "<span class='las la-user'></span>";
                                echo "<input type='datetime-local' id='time_in' name='time_in' value='".$time_in."'/>";
                                echo "</div>";
                                echo "</div>";
                                
                                echo "<div>";
                                echo "<label for='time_in'>Time Logged Out</label>";
                                echo "<div class='input-wrapper'>";
                                echo "<span class='las la-user'></span>";
                                echo "<input type='datetime-local' id='time_out' name='time_out' value='".$time_out."'/>";
                                echo "</div>";
                                echo "</div>";
                                
                                echo "<div>";
                                echo "<label for='state'>State</label>";
                                echo "<div class='input-wrapper'>";
                                echo "<span class='las la-university'></span>";
                                echo "<select id='state' name='state'>";
                                if($log_state=="active"){
                                    echo "<option selected value='active'>Active</option>";
                                    echo "<option value='active'>Active</option>";
                                }elseif($log_state=="inactive"){
                                    echo "<option value='active'>Active</option>";
                                    echo "<option selected value='inactive'>Inactive</option>";
                                }
                                echo "</select>";
                                echo "</div>";
                                echo "</div>";

                                echo "<input type='hidden' id='condition' name='condition' value='".$log_id."'/>";

                                // forward data to self
                                echo "<input class='submit' type='submit' name='log_edit' formmethod='post' value='Apply'/>";
                                echo "</form>";
                            }
                        ?>
                    </div>
                </div>
            </main>
        </div>
        <script>
        $(".submit").click(function(event) {
            if (confirm("Are you sure you want to proceed this edit?")) {
            } else {
                event.preventDefault();
            }
        });
        </script>
    </body>
</html>