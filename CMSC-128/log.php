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
            <div class="recent-grid">
                <div class="Users card">
                    <!-- table title -->
                    <div class="card-header">
                        <h2><span class="las la-users"></span> Charging History </h2>
                    </div>

                    <!-- table content -->
                    <div class="card-body">
                        <table width="100%">
                            <!-- table heading -->
                            <thead>
                                <tr>
                                    <td>LOG ID</td>
                                    <td>Tag No.</td>
                                    <td>Student No.</td>
                                    <td>Time in</td>
                                    <td>Time out</td>
                                    <td>State</td>
                                    <td> <a href='log_add.php'> Add </a> </td>
                                </tr>
                            </thead>

                            <!-- table body -->
                            <tbody>
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

                                // query for log info
                                $sql = "SELECT * FROM charging_log";
                                $result = mysqli_query($conn, $sql);

                                // log info rows
                                while($row = mysqli_fetch_assoc($result)) {
                                    if($row['state'] == '0')
                                        $log_state = "inactive";
                                    else
                                        $log_state = 'active';
                                    
                                    echo "<tr>";
                                    echo "<td>".$row['log_id']."</td>";
                                    echo "<td>".$row['tag_number']."</td>";
                                    echo "<td>".$row['student_number']."</td>";
                                    echo "<td>".$row['time_in']."</td>";
                                    echo "<td>".$row['time_out']."</td>";
                                    echo "<td>".$log_state."</td>";
                                    echo "<td> <a href='log_edit.php?
                                    log_id=".$row['log_id'].
                                    "&tag_number=".$row['tag_number'].
                                    "&student_number=".$row['student_number'].
                                    "&time_in=".$row['time_in'].
                                    "&time_out=".$row['time_out'].
                                    "&state=".$row['state'].
                                    "'>Edit</a> || <a href='log_delete.php?log_id=".$row['log_id'].
                                    "'>Delete</a></td>";
                                    echo "</tr>";
                                }

                                // close connection
                                mysqli_close($conn);
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>