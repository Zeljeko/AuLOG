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
                    <!-- form title -->
                    <div class="card-header">
                        <h2><span class="las la-users"></span> Add Student </h2>
                    </div>

                    <!-- add functionality -->
                    <div class="card-body">
                        <?php           
                            include 'functions.php';

                            if(isset($_POST["student_add"])) { // segment for processing add transaction
                                // assigning received data to variables
                                $rfid_tag = $_POST['rfid_tag'];
                                $first_name = $_POST["first_name"];
                                $last_name = $_POST["last_name"];
                                $student_number = $_POST["student_number"];
                                $college = $_POST["college"];
                                $email = $_POST["email"];
                                
                                // invoking add function
                                addstudent($rfid_tag, $first_name, $last_name, $student_number, $college, $email);
                            } else { // segment for outputting form
                                // form heading
                                echo "<form action='student_add.php' target='_self' method='post'>";
                                echo "<table width='100%'>";
                                echo "<tr>";
                                echo "<td>RFID Tag</td>";
                                echo "<td>First Name</td>";
                                echo "<td>Last Name</td>";
                                echo "</tr>";

                                
                                // input fields
                                echo "<tr>";
                                echo "<td> <input type='text' id='rfid_tag' name='rfid_tag' placeholder='RFID Tag'/> </td>";
                                echo "<td> <input type='text' id='first_name' name='first_name' placeholder='First Name'/> </td>";
                                echo "<td> <input type='text' id='last_name' name='last_name' placeholder='Last Name'/> </td>";
                                echo "</tr>";

                                // form heading ii
                                echo "<tr>";
                                echo "<td>Student Number</td>";
                                echo "<td>College</td>";
                                echo "<td>Email Address</td>";
                                echo "</tr>";

                                // input fields ii
                                echo "<tr>";
                                echo "<td> <input type='text' id='student_number' name='student_number' placeholder='xxxx-xxxxx'/> </td>";
                                echo "<td> <input type='text' id='college' name='college' placeholder='College'/> </td>";
                                echo "<td> <input type='text' id='email' name='email' placeholder='sample@email.com'/> </td>";
                                echo "</tr>";
                                echo "</table>";

                                // forward data to self
                                echo "<br/><input type='submit' name='student_add' formmethod='post' value='Apply'/>";
                                echo "</form>";
                            }
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>