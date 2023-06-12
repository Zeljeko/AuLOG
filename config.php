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
            $page = 'config';
            include 'includes/sidebars.php'
        ?>

        <!-- main content -->
        <div class="main-content">
            <!-- navigation bar -->
            <?php
            $page = 'config';
            include 'includes/header.php'
            ?>

            <!-- primary content -->
            <main>
                <div class="cards-config">
                    <div class="card">
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
                                echo "<div>";
                                echo "<select id='tag_number' name='tag_number'>";
                                $tag_number = 1;
                                while($tag_number <= 50) {
                                    if($tag_number != $number_of_tags)
                                        echo "<option value='$tag_number'>$tag_number</option>";
                                    else
                                        echo "<option selected value='$tag_number'>$tag_number</option>";

                                    $tag_number = $tag_number + 1;
                                }
                                echo "</select>";
                                echo "</div>";
                                // forward data to self
                                echo "<div>";
                                echo "<input class='submit-config' type='submit' name='number_of_tags' formmethod='post' value='Apply'/>";
                                echo "</div>";
                                echo "</form>";
                            }
                        ?>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h2><span class="las la-tools"></span> Configure Maximum Charging Time </h2>
                        </div>
                        <div class="card-body">
                        <?php       
                            if(isset($_POST["charging_time"])) { // segment for processing edit transaction
                                // assigning received data to variables
                                $charging_time = $_POST['charge_time'];

                                // update charging time
                                editMaximumChargingTime($charging_time);    
                            } else { // segment for outputting form
                                // assigning received data to variables
                                $charging_time = getMaximumChargingTime();

                                // form heading
                                echo "<form action='charging_time.php' target='_self' method='post'>";
                                echo "<div>";
                                echo "<label for='charge_time'>Allotted Charge (Minutes)</label>";
                                echo "<input class='input-charge' type='number' id='charge_time' name='charge_time' value='".$charging_time."'/>";
                                echo "<label id='hours-label' for='charge_time'></label>";
                                echo "</div>";
                                // forward data to self
                                echo "<div>";
                                echo "<input class='submit-config' type='submit' name='charging_time' formmethod='post' value='Apply'/>";
                                echo "</div>";
                                echo "</form>";
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <script>
            $(document).ready(function() {
                function convert(minutes) {
                    var hours = minutes / 60;
                    return hours.toFixed(2) + " hours";
                }
                function updateLabel() {
                    var minutes = parseInt($("#charge_time").val());
                    var convertedValue = convert(minutes);
                    $("#hours-label").text(convertedValue);
                }
                $("#charge_time").click(function() {
                    updateLabel();
                });
                $("#charge_time").on('input', function() {
                    updateLabel();
                });
            });
        </script>
    </body>
</html>