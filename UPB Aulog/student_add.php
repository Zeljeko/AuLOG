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
                
            <!-- sidebar label and student info page title -->
            <h2>
                <label for="nav-toggle"> <span class="las la-bars"></span> </label>
                Student Info
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
                            echo "<tr> <thead>";
                            echo "<td>RFID Tag</td>";
                            echo "<td>First Name</td>";
                            echo "<td>Last Name</td>";
                            echo "</tr> </thead>";

                            
                            // input fields
                            echo "<tr>";
                            echo "<td> <input type='text' id='rfid_tag' name='rfid_tag' value='RFID Tag'/> </td>";
                            echo "<td> <input type='text' id='first_name' name='first_name' value='First Name'/> </td>";
                            echo "<td> <input type='text' id='last_name' name='last_name' value='Last Name'/> </td>";
                            echo "</tr>";

                            // form heading ii
                            echo "<tr>";
                            echo "<td>Student No.</td>";
                            echo "<td>College</td>";
                            echo "<td>Email Address</td>";
                            echo "</tr>";

                            // input fields ii
                            echo "<tr>";
                            echo "<td> <input type='text' id='student_number' name='student_number' value='XXXX-YYYYY'/> </td>";
                            echo "<td> <input type='text' id='college' name='college' value='College'/> </td>";
                            echo "<td> <input type='text' id='email' name='email' value='sample@email.com'/> </td>";
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