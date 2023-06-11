<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include 'includes/head.php'
        ?>
    </head>
    <body>

        <?php
            $page = 'numTags';
            include 'includes/sidebars.php'
        ?>

        <!-- main content -->
        <div class="main-content">
            <!-- navigation bar -->
            <?php
            $page = 'numTags';
            include 'includes/header.php'
            ?>

            <!-- primary content -->
            <main>
                <div class="recent-grid Users card">
                    <!-- Form Title -->
                    <div class="card-header">
                        <h2><span class="las la-tags"></span> Configure Maximum Number of Tags </h2>
                    </div>

                    <!-- edit functionallity -->
                    <div class="card-body">
                        <?php       
                        require 'functions.php';

                        if(isset($_POST["number_of_tags"])) { // segment for processing edit transaction
                            // assigning received data to variables
                            $number_of_tags = $_POST['tag_number'];

                            // update charging time
                            editNumberOfTags($number_of_tags);    
                        } else { // segment for outputting form
                            $number_of_tags = getNumberOfTags();

                            // form heading
                            echo "<form action='number_of_tags.php' target='_self' method='post'>";
                            echo "<label for='tag_number'>Number of Tags:</label>";
                            echo "&nbsp&nbsp<select id='tag_number' name='tag_number'>";
                            $tag_number = 1;
                            while($tag_number <= 50) {
                                if($tag_number != $number_of_tags)
                                    echo "<option value='$tag_number'>$tag_number</option>";
                                else
                                    echo "<option selected value='$tag_number'>$tag_number</option>";

                                $tag_number = $tag_number + 1;
                            }
                            echo "</select>";

                            // forward data to self
                            echo "&nbsp&nbsp<input type='submit' name='number_of_tags' formmethod='post' value='Apply'/>";
                            echo "</form>";
                        }
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>