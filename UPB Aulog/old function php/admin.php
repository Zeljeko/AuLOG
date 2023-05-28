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
                
                <!-- sidebar label and admin page title -->
                <h2>
                    <label for="nav-toggle"> <span class="las la-bars"></span> </label>
                    Admin
                </h2>
                
                <!-- site logo -->
                <div class="logo-wrapper">
                    <h4>UP Baguio Library</h4>
                    <small>Admin</small>
                </div>
            </header>

            <!-- primary content -->
            <main>
                <!-- active users -->
                <div class="cards card-single">
                    <h2> <a href='student.php'> Student Information </a> </h2>
                </div>

                <!-- charging logs -->
                <div class="cards card-single">
                    <h2> <a href='log.php'> Charging Logs </a> </h2>
                </div>

                <!-- max charging time -->
                <div class="cards card-single">
                    <h2> <a href='charging_time.php'> Maximum Charging Time </a> </h2>
                </div>

                <!-- number of tags -->
                <div class="cards card-single">
                    <h2> <a href='number_of_tags.php'> Number of Tags </a> </h2>
                </div>
            </main>
        </div>
    </body>
</html>