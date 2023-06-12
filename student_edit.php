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
                        <h2><span class="las la-users"></span> Edit Student Information</h2>
                        <h3><a href='student.php'>Return</a></h3>
                    </div>

                    <!-- edit functionallity -->
                    <div class="card-body formfield">
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

                            echo "<form action='student_edit.php' target='_self' method='post'>";
                            echo "<div>";
                            echo "<label for='rfid_tag'>RFID Tag</label>";
                            echo "<div class='input-wrapper'>";
                            echo "<span class='las la-hashtag'></span>";
                            echo "<input type='text' id='rfid_tag' name='rfid_tag' placeholder='10-digit RFID Tag' minlength='10' maxlength='10' value='".$rfid_tag."'/>";
                            echo "</div>";
                            echo "</div>";

                            echo "<div>";
                            echo "<label for='student_number'>Student Number</label>";
                            echo "<div class='input-wrapper'>";
                            echo "<span class='las la-address-card'></span>";
                            echo "<input type='text' id='student_number' name='student_number' placeholder='xxxx-xxxxx' value='".$student_number."'/>";
                            echo "</div>";
                            echo "</div>";
                            
                            echo "<div>";
                            echo "<label for='first_name'>First Name</label>";
                            echo "<div class='input-wrapper'>";
                            echo "<span class='las la-user'></span>";
                            echo "<input type='text' id='first_name' name='first_name' placeholder='First Name' value='".$first_name."'/>";
                            echo "</div>";
                            echo "</div>";
                            
                            echo "<div>";
                            echo "<label for='last_name'>Last Name</label>";
                            echo "<div class='input-wrapper'>";
                            echo "<span class='las la-user'></span>";
                            echo "<input type='text' id='last_name' name='last_name' placeholder='Last Name' value='".$last_name."'/>";
                            echo "</div>";
                            echo "</div>";
                            
                            echo "<div>";
                            echo "<label for='college'>College</label>";
                            echo "<div class='input-wrapper'>";
                            echo "<span class='las la-university'></span>";
                            echo "<select id='college' name='college'>";
                            if($college=="Arts and Communication"){
                                echo "<option value='Arts and Communication'>Arts and Communication</option>";
                                echo "<option selected value='Science'>Science</option>";
                                echo "<option value='Social Sciences'>Social Science</option>";
                            }elseif($college=="Science"){
                                echo "<option value='Arts and Communication'>Arts and Communication</option>";
                                echo "<option selected value='Science'>Science</option>";
                                echo "<option value='Social Sciences'>Social Science</option>";
                            }elseif($college=="Social Sciences"){
                                echo "<option value='Arts and Communication'>Arts and Communication</option>";
                                echo "<option value='Science'>Science</option>";
                                echo "<option selected value='Social Sciences'>Social Science</option>";
                            }
                            echo "</select>";
                            echo "</div>";
                            echo "</div>";
                            
                            echo "<div>";
                            echo "<label for='email'>Email</label>";
                            echo "<div class='input-wrapper'>";
                            echo "<span class='las la-envelope'></span>";
                            echo "<input type='text' id='email' name='email' placeholder='sample@email.com' value='".$email."'/>";
                            echo "</div>";
                            echo "</div>";

                            echo "<div>";
                            echo "<label for='email'>Hours Consumed</label>";
                            echo "<div class='input-wrapper'>";
                            echo "<span class='las la-battery'></span>";
                            echo "<input type='number' id='hours' name='hours' placeholder='Set hours consumed' value='".$hours."'/>";
                            echo "</div>";
                            echo "</div>";

                            echo "<div>";
                            echo "<label for='email'>Minutes Consumed</label>";
                            echo "<div class='input-wrapper'>";
                            echo "<span class='las la-battery'></span>";
                            echo "<input type='number' id='minutes' name='minutes' placeholder='Set minutes consumed' value='".$minutes."'/>";
                            echo "</div>";
                            echo "</div>";

                            echo "<input type='hidden' id='condition' name='condition' value='".$student_number."'/>";
                            // forward data to self
                            echo "<input class='submit' type='submit' name='student_edit' formmethod='post' value='Apply'/>";
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