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

            <!-- header -->
            <?php
            $page = 'studInfo';
            include 'includes/header.php'
            ?>

            <!-- primary content -->
            <main>
                <div class="grid">
                    <div class="card">
                        <!-- table title -->
                        <div class="card-header">
                            <h2><span class="las la-users"></span> Students</h2>
                            <h3><a href='student_add.php'><span class='las la-plus'></span>  Add User </a></h3>
                        </div>

                        <!-- table content -->
                        <div class="card-body">
                            <table id="tableSort" width="100%">
                                <!-- table heading -->
                                <thead>
                                    <tr>
                                        <td>Actions</td>
                                        <td>RFID Tag <span class='las la-sort'></span></td>
                                        <td>Student No. <span class='las la-sort'></td>
                                        <td>Name <span class='las la-sort'></td>
                                        <td>College <span class='las la-sort'></td>
                                        <td>Email Address <span class='las la-sort'></td>
                                        <td>Charge Consumed <span class='las la-sort'></td>
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
                                            echo "<td> <a class='edit' href='student_edit.php?
                                            rfid_tag=".$row['rfid_tag'].
                                            "&first_name=".$row['first_name'].
                                            "&last_name=".$row['last_name'].
                                            "&student_number=".$row['student_number'].
                                            "&college=".$row['college'].
                                            "&email=".$row['email'].
                                            "&charge_consumed=".$row['charge_consumed'].
                                            "'><span class='las la-edit'></span></a> 
                                            
                                            <a class='end' href='db-requests/student_delete.php?student_number=".$row['student_number'].
                                            "'><span class='las la-minus'></span></a></td>";
                                            echo "<td>".$row['rfid_tag']."</td>";
                                            echo "<td>".$row['student_number']."</td>";
                                            echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
                                            echo "<td>".$row['college']."</td>";
                                            echo "<td>".$row['email']."</td>";
                                            echo "<td>".$hours." hours ".$minutes." minutes</td>";
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
        <script src="assets/table-sort-script.js"></script>
        <script>
        $(".edit").click(function(event) {
            if (confirm("Are you sure you want to proceed to edit?")) {
            } else {
                event.preventDefault();
            }
        });
        $(".end").click(function(event) {
            if (confirm("Are you sure you want to proceed to delete?")) {
            } else {
                event.preventDefault();
            }
        });
        </script>
    </body>
</html>

