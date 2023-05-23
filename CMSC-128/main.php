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

        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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
                <!-- active user count reload -->
                <script> 
                    $(document).ready(function(){
                    setInterval(function(){
                        $("#active-number").load(window.location.href + " #active-number" );
                    }, 3000);
                    });
                </script>

                <!-- active user count -->
                <div class="cards" id = "active-number">
                    <div class="card-single">
                        <?php
                            require 'functions.php';
                            $result = getActiveStudents();
                            echo "<h1>".count($result)." currently active user/s </h1>";
                        ?>
                    </div>
                </div>

                <!-- table of active users -->
                <div class="recent-grid Users card">
                    <!-- table title -->
                    <div class="card-header">
                        <h2><span class="las la-users"></span> Users</h2>
                    <form action='start_charging_session.php' target='_self' method='post'>
                            <input type = 'text' id = 'student_number' name = 'student_number' value = 'Student No.'/>
                            <input type = 'text' id = 'tag_number' name = 'tag_number' value = 'Tag No.' size = '4'/> 
                            <input type='submit' name='start_charging_session' formmethod='post' value='Start'>
                        </form>
                    </div>

                    <!-- table content reload -->
                    <script>
                        $(document).ready(function(){
                        setInterval(function(){
                            $("#active-students").load(window.location.href + " #active-students" );
                        }, 3000);
                        });
                    </script>

                    <!-- table content -->
                    <div class="card-body" id = "active-students">
                        <table width="100%">
                            <!-- table heading -->
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Remaining Charge</td>
                                    <td>Time Elapsed</td>
                                </tr>
                            </thead>
  
                            <tbody>   
                            <?php
                                $result = getActiveStudents();

                                // displaying student entries
                                foreach($result AS $row) {
                                    $hours = intdiv(getRemainingCharge($row['student_number']), 60);
                                    $minutes = getRemainingCharge($row['student_number']) % 60;

                                    $diff_hours = intdiv($row['difference'], 60);
                                    $dif_minutes = $row['difference'] % 60;
                                    
                                    echo "<tr>";
                                    echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
                                    echo "<td>".$hours." hours ".$minutes." minutes</td>";
                                    echo "<td>".$diff_hours." hours ".$dif_minutes." minutes</td>";
                                    echo "<td> <a href='end_charging_session.php?
                                    log_id=".$row['log_id'].
                                    "&time_in=".$row['time_in']."'>End</a></td>";
                                    echo "</tr>";
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>