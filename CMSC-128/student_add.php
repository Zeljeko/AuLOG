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
                    <a href="student.php" class="active"><span class="las la-users"></span>
                    <span>Admin</span></a>
                </li>
            </ul>
        </div>
    </div>

    <!-- main content -->
    <div class="main-content">
        <!-- navigation bar -->
        <header>
                
            <!-- sidebar label and main page title -->
            <h2>
                <label for="nav-toggle"> <span class="las la-bars"></span> </label>
                Dashboard
            </h2>

            <!-- searchbar -->
            <div class="search-wrapper">
                <span class="las la-search"></span>
                <input type="search" placeholder="Search here" />
            </div>
            
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
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $database = "aulog_database";
                                
                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $database);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        if(isset($_POST["student_add"])) {
                            // assigning forwarded data to variables
                            $first_name = $_POST["first_name"];
                            $last_name = $_POST["last_name"];
                            $student_number = $_POST["student_number"];
                            $email = $_POST["email"];
                            
                            // inserting studeing info
                            $sql = "INSERT INTO student (first_name, last_name, student_number, email, charge_consumed) 
                                    VALUES ('$first_name', '$last_name', '$student_number', '$email', '0')";
                            
                            if (mysqli_query($conn, $sql)) {
                                echo "<script type='text/javascript'>alert('Entry added. Redirecting you back to the admin page.');
                                window.location.href='student.php';</script>";
                            } else {
                                echo "<script type='text/javascript'>alert('Cannot add entry.');
                                window.location.href='student.php';</script>";
                            }
                        } else {
                            // form heading
                            echo "<form action='student_add.php' target='_self' method='post'>";
                            echo "<table width='100%'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<td>First Name</td>";
                            echo "<td>Second Name</td>";
                            echo "<td>Student No.</td>";
                            echo "<td>Email Address</td>";
                            echo "</tr>";
                            echo "</thead>";
                            
                            // input fields
                            echo "<tbody> <tr>";
                            echo "<td> <input type='text' id='first_name' name='first_name' value='First Name'/> </td>";
                            echo "<td> <input type='text' id='last_name' name='last_name' value='Last Name'/> </td>";
                            echo "<td> <input type='text' id='student_number' name='student_number' value='XXXX-YYYYY'/> </td>";
                            echo "<td> <input type='text' id='email' name='email' value='sample@email.com'/> </td>";
                            echo "</tr> </tbody>";
                            echo "</table>";

                            echo "<br/><input type='submit' name='student_add' formmethod='post' value='Apply'>";
                            echo "</form>";
                        }

                        // close connection
                        mysqli_close($conn);
                    ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>