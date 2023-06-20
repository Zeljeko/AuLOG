<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include 'includes/head.php'
        ?>
    </head>
    <body>

        <?php
            $page = 'tagEdit';
            include 'includes/sidebars.php'
        ?>

        <!-- main content -->
        <div class="main-content">

            <!-- header -->
            <?php
            $page = 'main';
            include 'includes/header.php'
            ?>

            <!-- primary content -->
            <main>
                <div class="cards-config">
                <div class="card">
                    <!-- Form Title -->
                    <div class="card-header">
                        <?php
                            require 'functions.php';

                            if(isset($_POST["tag_edit"])) { // segment for processing edit transaction
                                // assigning received data to variables
                                $condition = $_POST['condition'];
                                $tag_number = $_POST['tag_number'];
                                // invoking edit function
                                editTagNumber($condition, $tag_number);
                            } 
                            
                            else { // segment for outputting form
                                // assigning received data to variables
                                $log_id = $_GET['log_id'];
                                $tag_number = $_GET['tag_number'];
                                $student_number = $_GET['student_number'];
                        ?>
                        <h2><span class="las la-users"></span> Editing Tag Number of <?php echo $student_number;?> </h2>
                    </div>

                    <!-- edit functionallity -->
                    <div class="card-body">
                        <?php
                                // form heading
                                echo "<form action='tag_edit.php' target='_self' method='post'>";
                                echo "<div>";
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
                                echo "</div>";
                                echo "<div>";
                                // forward data to self
                                echo "<input type='hidden' name='condition' value=$log_id />";
                                echo "<input class='submit-config' type='submit' name='tag_edit' formmethod='post' value='Apply'/>";
                                echo "</div>";
                                echo "</form>";
                            }
                        ?>
                    </div>
                </div>
            </main>
        </div>
        <script src="assets/script.js"></script>
    </body>
</html>