<!DOCTYPE html>
<html lang="en">
<head>
    <?php
            include 'includes/head.php'
    ?>
</head>
    <body>

        <?php
            $page = 'chargeTime'; 
            include 'includes/sidebars.php'
        ?>

        <!-- main content -->
        <div class="main-content">
            <!-- header -->
            <?php
            $page = 'chargeTime'; 
            include 'includes/header.php'
            ?>

            <!-- primary content -->
            <main>
                <div class="recent-grid Users card">
                    <!-- Form Title -->
                    <div class="card-header">
                        <h2><span class="las la-tools"></span> Configure Maximum Charging Time </h2>
                    </div>

                    <!-- edit functionallity -->
                    <div class="card-body">
                        <?php       
                        require 'functions.php';

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
                            echo "<label for='charge_time'>Charging Time:</label>";
                            echo "&nbsp&nbsp<input type='number' id='charge_time' name='charge_time' value='".$charging_time."'/>";
                            
                            // forward data to self
                            echo "&nbsp<input type='submit' name='charging_time' formmethod='post' value='Apply'/>";
                            echo "</form>";
                        }
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>