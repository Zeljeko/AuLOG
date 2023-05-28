<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include 'includes/head.php'
        ?>
    </head>
    <body>

        <?php
            include 'includes/sidebar.php'
        ?>

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