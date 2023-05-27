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
                
            <!-- sidebar label and tag number edit page title -->
            <h2>
                <label for="nav-toggle"> <span class="las la-bars"></span> </label>
                Dashboard
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
                <!-- Form Title -->
                <div class="card-header">
                    <h2><span class="las la-users"></span> Edit Tag Number </h2>
                </div>

                <!-- edit functionallity -->
                <div class="card-body">
                    <?php
                        require 'functions.php';

                        if(isset($_POST["tag_edit"])) { // segment for processing edit transaction
                            // assigning received data to variables
                            $condition = $_POST['condition'];
                            $tag_number = $_POST['tag_number'];


                            // invoking edit function
                            editTagNumber($condition, $tag_number);
                        } else { // segment for outputting form
                            // assigning received data to variables
                            $log_id = $_GET['log_id'];
                            $tag_number = $_GET['tag_number'];
                            $student_number = $_GET['student_number'];

                            // form heading
                            echo "<form action='tag_edit.php' target='_self' method='post'>";
                            echo "<table width='100%'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<td>Student No.</td>";
                            echo "<td>Tag No.</td>";
                            echo "</tr>";
                            echo "</thead>";
                                                
                            
                            echo "<tbody> <tr>";
                            echo "<td> $student_number </td>";
                            echo "<td>";

                            // tag input field
                            $number_of_tags = getNumberOfTags();
                            echo "<select id='tag_number' name='tag_number'>";
                            $tag_count = 1;
                            while($tag_count <= $number_of_tags) {
                                if($tag_count != $tag_number)
                                    echo "<option value='$tag_count'>$tag_count</option>";
                                else
                                    echo "<option selected value='$tag_count'>$tag_count</option>";

                                $tag_count = $tag_count + 1;
                            }
                            echo "</select>";


                            // forward data to self
                            echo "<input type='hidden' name='condition' value=$log_id />";
                            echo "<td> <input type='submit' name='tag_edit' formmethod='post' value='Apply'/> </td>";
                            echo "</td>";
                            echo "</tr> </tbody> ";
                            echo "</table>";

                            echo "</form>";
                        }
                    ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>