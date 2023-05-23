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

            <!-- searchbar -->
            <form action='student.php' target='_self' method='post'>
                <div class="search-wrapper">
                    <span class="las la-search"></span>
                    <input type="search" id='student_number' name = 'student_number' placeholder="Student No." />
                    <input type='submit' name='student' formmethod='post' value='Search'>
                </div>
            </form>
            
            
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
                        <h2><span class="las la-users"></span> Students</h2>
                    </div>

                    <!-- table content -->
                    <div class="card-body">
                        <table width="100%">
                            <!-- table heading -->
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Student No.</td>
                                    <td>Email Address</td>
                                    <td>Charge Consumed</td>
                                    <td> <a href='student_add.php'> Add </a> </td>
                                </tr>
                            </thead>

                            <!-- table body -->
                            <tbody>
                                <?php
                                    require 'functions.php';
                                    
                                    if(isset($_POST["student"]))
                                        $result = getStudent($_POST['student_number']); // single student info
                                    else  
                                        $result = getStudents(); // student info

                                    // output student info
                                    foreach($result AS $row) {
                                        $hours = intdiv($row['charge_consumed'],60);
                                        $minutes = $row['charge_consumed'] % 60;
                                            
                                        echo "<tr>";
                                        echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
                                        echo "<td>".$row['student_number']."</td>";
                                        echo "<td>".$row['email']."</td>";
                                        echo "<td>".$hours." hours ".$minutes." minutes</td>";
                                        echo "<td> <a href='student_edit.php?
                                        first_name=".$row['first_name'].
                                        "&last_name=".$row['last_name'].
                                        "&student_number=".$row['student_number'].
                                        "&email=".$row['email'].
                                        "&charge_consumed=".$row['charge_consumed'].
                                        "'>Edit</a> || <a href='student_delete.php?student_number=".$row['student_number'].
                                        "'>Delete</a></td>";
                                        echo "</tr>";
                                    }
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