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
                    <!-- form title -->
                    <div class="card-header">
                        <h2><span class="las la-users"></span> Add New Student Information </h2>
                        <h3><a href='student.php'>Return</a></h3>
                    </div>

                    <!-- add functionality -->
                    <div class="card-body formfield">
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
                                echo "<div>";
                                echo "<label for='rfid_tag'>RFID Tag</label>";
                                echo "<div class='input-wrapper'>";
                                echo "<span class='las la-hashtag'></span>";
                                echo "<input type='text' id='rfid_tag' name='rfid_tag' placeholder='10-digit RFID Tag' minlength='10' maxlength='10' />";
                                echo "</div>";
                                echo "</div>";

                                echo "<div>";
                                echo "<label for='student_number'>Student Number</label>";
                                echo "<div class='input-wrapper'>";
                                echo "<span class='las la-address-card'></span>";
                                echo "<input type='text' id='student_number' name='student_number' placeholder='xxxx-xxxxx'/>";
                                echo "</div>";
                                echo "</div>";
                                
                                echo "<div>";
                                echo "<label for='first_name'>First Name</label>";
                                echo "<div class='input-wrapper'>";
                                echo "<span class='las la-user'></span>";
                                echo "<input type='text' id='first_name' name='first_name' placeholder='First Name'/>";
                                echo "</div>";
                                echo "</div>";
                                
                                echo "<div>";
                                echo "<label for='last_name'>Last Name</label>";
                                echo "<div class='input-wrapper'>";
                                echo "<span class='las la-user'></span>";
                                echo "<input type='text' id='last_name' name='last_name' placeholder='Last Name'/>";
                                echo "</div>";
                                echo "</div>";
                                
                                echo "<div>";
                                echo "<label for='college'>College</label>";
                                echo "<div class='input-wrapper'>";
                                echo "<span class='las la-university'></span>";
                                echo "<select id='college' name='college'>";
                                echo "<option value='' disabled selected hidden>Choose a College</option>";
                                echo "<option value='Arts and Communication'>Arts and Communication</option>";
                                echo "<option value='Science'>Science</option>";
                                echo "<option value='Social Sciences'>Social Science</option>";
                                echo "</select>";
                                echo "</div>";
                                echo "</div>";
                                
                                echo "<div>";
                                echo "<label for='email'>Email</label>";
                                echo "<div class='input-wrapper'>";
                                echo "<span class='las la-envelope'></span>";
                                echo "<input type='text' id='email' name='email' placeholder='sample@email.com'/>";
                                echo "</div>";
                                echo "</div>";
                                // forward data to self
                                echo "<input class='submit' type='submit' name='student_add' formmethod='post' value='Apply'/>";
                                echo "</form>";
                            }
                        ?>
                    </div>
                </div>
            </main>
        </div>
        <script>
        $(".submit").click(function(event) {
            if (confirm("Are you sure you want to proceed adding this student?")) {
            } else {
                event.preventDefault();
            }
        });
        </script>
    </body>
</html>