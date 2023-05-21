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
                    <a href="main.php" class="active"><span class="las la-igloo"></span>
                    <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="admin.php"><span class="las la-users"></span>
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

                Dashboard
            </h2>

            <div class="search-wrapper">
                <span class="las la-search"></span>
                <input type="search" placeholder="Search here" />
            </div>
                
            <div class="logo-wrapper">
                <div>
                    <h4>UP Baguio Library</h4>
                    <small>Admin</small>
                </div>
            </div>
        </header>

        <main>
            <div class="cards">
                <div class="card-single">
                    <div>
                        <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $database = "aulog_database";
                            
                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $database);

                            $sql = "SELECT state FROM charging_log WHERE state = 1";
                            $result = mysqli_query($conn, $sql);
                            $active = count(mysqli_fetch_assoc($result));

                            echo "<h1>".$active."</h1>";
                            echo "<span>Currently Active Users</span>";
                            mysqli_close($conn);
                        ?>
                        
                    </div>
                    <div>
                        <span class="lab la-user"></span>
                    </div>
                </div>
            </div>

            <div class="recent-grid">
                <div class="Users">
                    <div class="card">
                        <div class="card-header">
                            <h2><span class="las la-users"></span> Users</h2>

                            <button>See all <span class="las la-arrow-right"></span></button>
                        </div>

                        <div class="card-body">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <td>Name</td>
                                        <td>Charge Consumed</td>
                                        <td>Time Elapsed</td>
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php
                                        $servername = "localhost";
                                        $username = "root";
                                        $password = "";
                                        $database = "aulog_database";
                                        
                                        // Create connection
                                        $conn = new mysqli($servername, $username, $password, $database);

                                        $sql = "SELECT first_name, last_name, student.student_number, email, charge_consumed FROM student JOIN charging_log
                                        ON student.student_number = charging_log.student_number
                                        WHERE state = 1";
                                        $result = mysqli_query($conn, $sql);
                                        
                                        while($row = mysqli_fetch_assoc($result)) {
                                            $hours = intdiv($row['charge_consumed'],60);
                                            $minutes = $row['charge_consumed'] % 60;

                                            $text_hours = "".$hours."";
                                            $text_minutes = "".$minutes."";
                                            if($hours < 10) {
                                                $text_hours = "0".$hours;
                                            }
                                            
                                            if($minutes < 10) {
                                                $text_minutes = "0".$minutes;
                                            }

                                            echo "<tr>";
                                            echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
                                            echo "<td>".$text_hours.":".$text_minutes."</td>";
                                            echo "</tr>";
                                        }

                                        mysqli_close($conn);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>