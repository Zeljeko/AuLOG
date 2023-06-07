<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
                include 'includes/head.php'
        ?>
    </head>
    <body>

        <?php
            $page='studInfo';
            include 'includes/sidebars.php'
        ?>

        <!-- main content -->
        <div class="main-content">
            <!-- navigation bar -->
            <?php
            $page = 'studInfoAddEdit';
            include 'includes/header.php'
            ?>

            <!-- primary content -->
            <main>
                <div class="recent-grid Users card">
                    <!-- Form Title -->
                    <div class="card-header">
                        <h2><span class="las la-users"></span> Edit Student Info </h2>
                    </div>

                    <!-- edit functionallity -->
                    <div class="card-body">
                        <?php       
                        require 'functions.php';

                        if(isset($_POST["student_edit"])) { // segment for processing edit transaction
                            // assigning received data to variables
                            $condition = $_POST['condition'];
                            $rfid_tag = $_POST['rfid_tag'];
                            $first_name = $_POST['first_name'];
                            $last_name = $_POST['last_name'];
                            $student_number = $_POST['student_number'];
                            $college = $_POST['college'];
                            $email = $_POST['email'];

                            $hours = $_POST['hours'];
                            $minutes = $_POST['minutes'];
                            $charge_consumed = ($hours * 60) + $minutes;

                            // update student info
                            editStudent($rfid_tag, $first_name, $last_name, $student_number, $college, $email, $charge_consumed, $condition);    
                        } else { // segment for outputting form
                            // assigning received data to variables
                            $rfid_tag = $_GET['rfid_tag'];
                            $first_name = $_GET['first_name'];
                            $last_name = $_GET['last_name'];
                            $student_number = $_GET['student_number'];
                            $college = $_GET['college'];
                            $email = $_GET['email'];
                            $charge_consumed = $_GET['charge_consumed'];

                            $hours = intdiv($charge_consumed,60);
                            $minutes = $charge_consumed % 60;

                            // form heading i
                            echo "<form action='student_edit.php' target='_self' method='post'>";
                            echo "<table width='100%'>";
                            echo "<tr>";
                            echo "<td>RFID Tag</td>";
                            echo "<td>First Name</td>";
                            echo "<td>Last Name</td>";
                            echo "<td>Student Number</td>";
                            echo "</tr>";
                            
                            // input fields i
                            echo "<tbody> <tr>";
                            echo "<td> <input type='text' id='rfid_tag' name='rfid_tag' value='".$rfid_tag."'/> </td>";
                            echo "<td> <input type='text' id='first_name' name='first_name' value='".$first_name."'/> </td>";
                            echo "<td> <input type='text' id='last_name' name='last_name' value='".$last_name."'/> </td>";
                            echo "<td> <input type='text' id='student_number' name='student_number' value='".$student_number."'/> </td>";
                            echo "</tr>";

                            // form heading ii
                            echo "<tr>";
                            echo "<td>College</td>";
                            echo "<td>Email Address</td>";
                            echo "<td>Hours</td>";
                            echo "<td>Minutes</td>";
                            echo "</tr>";

                            // input fields ii
                            echo "<tr>";
                            echo "<td> <input type='text' id='college' name='college' value='".$college."'/> </td>";
                            echo "<td> <input type='text' id='email' name='email' value='".$email."'/> </td>";
                            echo "<td> <input type='number' id='hours' name='hours' value='".$hours."'/> </td>";
                            echo "<td> <input type='number' id='minutes' name='minutes' value='".$minutes."'/> </td>";
                            echo "</tr> </tbody>";
                            echo "</table>";

                            echo "<input type='hidden' id='condition' name='condition' value='".$student_number."'/>";

                            // forward data to self
                            echo "<br/><input type='submit' name='student_edit' formmethod='post' value='Apply'/>";
                            echo "</form>";
                        }
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>