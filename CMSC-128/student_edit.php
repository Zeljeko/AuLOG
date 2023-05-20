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

    <input type="checkbox" id="nav-toggle">
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

    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>

                Edit
            </h2>
                
            <div class="logo-wrapper">
                <div>
                    <h4>UP Baguio Library</h4>
                    <small>Admin</small>
                </div>
            </div>
        </header>

        <main>
            <div class="recent-grid">
                <div class="Users card">
                    <div class="card-header">
                        <h2><span class="las la-users"></span> Students</h2>
                    </div>

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

                            if(isset($_POST["student_edit"])) {
                                $condition = $_POST['condition'];
                                $first_name = $_POST['first_name'];
                                $last_name = $_POST['last_name'];
                                $student_number = $_POST['student_number'];
                                $email = $_POST['email'];

                                $hours = $_POST['hours'];
                                $minutes = $_POST['minutes'];
                                $charge_consumed = ($hours * 60) + $minutes;

                                $sql = "UPDATE student
                                SET first_name = '$first_name', last_name = '$last_name', student_number = '$student_number', email = '$email', charge_consumed = '$charge_consumed'
                                WHERE student_number = '$condition'";

                                if (mysqli_query($conn, $sql)) {
                                    echo "<script type='text/javascript'>alert('Edit successful.');
                                    window.location.href='admin.php';</script>";
                                } else {
                                    echo "<script type='text/javascript'>alert('Edit unsuccessful.');
                                    window.location.href='admin.php';</script>";
                                }

                                
                            } else {
                                $first_name = $_GET['first_name'];
                                $last_name = $_GET['last_name'];
                                $student_number = $_GET['student_number'];
                                $email = $_GET['email'];
                                $charge_consumed = $_GET['charge_consumed'];

                                $hours = intdiv($charge_consumed,60);
                                $minutes = $charge_consumed % 60;

                                $text_hours = "".$hours."";
                                $text_minutes = "".$minutes."";
                                if($hours < 10) {
                                    $text_hours = "0".$hours;
                                }
                                
                                if($minutes < 10) {
                                    $text_minutes = "0".$minutes;
                                }

                                echo "<form action='student_edit.php' target='_self' method='post'>";
                                echo "<table width='100%'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<td>First Name</td>";
                                echo "<td>Second Name</td>";
                                echo "<td>Student No.</td>";
                                echo "<td>Email Address</td>";
                                echo "<td>Hours</td>";
                                echo "<td>Minutes</td>";
                                echo "</tr>";
                                echo "</thead>";
                                
                                
                                echo "<tbody> <tr>";
                                echo "<td> <input type='text' id='first_name' name='first_name' value='".$first_name."'/> </td>";
                                echo "<td> <input type='text' id='last_name' name='last_name' value='".$last_name."'/> </td>";
                                echo "<td> <input type='text' id='student_number' name='student_number' value='".$student_number."'/> </td>";
                                echo "<td> <input type='text' id='email' name='email' value='".$email."'/> </td>";
                                echo "<td> <input type='number' id='hours' name='hours' value='".$text_hours."'/> </td>";
                                echo "<td> <input type='number' id='minutes' name='minutes' value='".$text_minutes."'/> </td>";
                                echo "</tr> </tbody>";
                                echo "</table>";

                                echo "<input type='hidden' id='condition' name='condition' value='".$student_number."'/>";

                                echo "<br/><input type='submit' name='student_edit' formmethod='post' value='Apply'>";
                                echo "</form>";
                            }
                            mysqli_close($conn);
                        ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>