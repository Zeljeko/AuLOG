<!DOCTYPE html>
<html lang="en">
    <head>
    <?php
		include 'includes/head.php'
	?>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js" ></script>
    <script src="assets/chart-script.js"></script>
    </head>

    <body>
        <?php
        $page = 'main';
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

                <!-- active user count -->
                <div class="cards">
                    <div class="card card-single">
                        <div>
                            <h1>
                            <?php
                            require 'functions.php';
                            $result = getActiveStudents();
                            echo count($result);
                            ?>
                            </h1>
                            <p>Active Users</p>
                        </div>
                        <div>
                            <span class='las la-user'></span>
                        </div>
                        <div>
                            <h1 id="nextTag">
                            </h1>
                            <p>Next Tag Available</p>
                        </div>
                        <div>
                            <span class='las la-tag'></span>
                        </div>
                    </div>
                    <div class="card card-input">
                        <div>
                            <h1>
                            <span class='las la-search'></span> ID Scanner 
                            </h1>
                            <span>Accepts RFID and Barcode</span>
                        </div>
                        <form class="form-input" id="rfid_form" action='db-requests/start_charging_session.php' method='post' autocomplete="off">
                            <div class="input-wrapper">
                                <input class="field_input" type = 'text' id = 'field_input' placeholder ="Place your ID onto the scanner">
                                <input class="field_sn" type = 'text' id = 'student_number' name = 'student_number' style="display: none;">
                                <input class="field_rfid" type = 'text' id = 'rfid_tag' name = 'rfid_tag' style="display: none;">
                                
                                <select class="tag_number" id = 'tag_number' name = 'tag_number' style="display: none;">
                                <?php
                                    $number_of_tags = getNumberOfTags();

                                    $tag_number = 1;
                                    while($tag_number <= $number_of_tags) {
                                        echo "<option value = '".$tag_number."'>".$tag_number."</option>";
                                        $tag_number = $tag_number + 1;
                                    }


                                ?>
                                </select>
                                <button id="id_submit" name='start_charging_session' formmethod='post'> <span class="las la-share"></span></button>
                            </div>
                        </form>
                    </div>
                    <!-- <div class="grid card card-single">
                        <div class="card-header">
                            <h2><span class="las la-users"></span> Daily Usage</h2>
                        </div>
                        <div id="chart-container-dashboard">
                            <?php
                            require_once 'functions.php';
                            $dailyData = generateDailyReport();
                            ?>
                            <canvas id="dailyChart"></canvas>
                        </div>
                    </div> -->
                </div>

                <!-- table of active users -->
                <div class="grid card">
                    <!-- table title -->
                    <div class="card-header">
                        <h2><span class="las la-users"></span> Users</h2>
                        <h3><a href='student.php' id="seeall" style="display:none;"> See All <span class='las la-arrow-circle-right'></span></a></h3>
                    </div>

                    <!-- table content -->
                    <div class="card-body">
                        <table width="100%" id = "dynamicTable">
                            <!-- table heading -->
                            <thead>
                                <tr>
                                    <td id="actionHead" style="display:none;">Action</td>
                                    <td id="rfidHead" style="display:none;">RFID Tag</td>
                                    <td id="snHead" style="display:none;">Student Number</td>
                                    <td>Time In</td>
                                    <td>Tag No. </td>
                                    <td>Name</td>
                                    <td>College</td>
                                    <td>Remaining Charge</td>
                                    <td>Time Elapsed</td>
                                </tr>
                            </thead>
  
                            <tbody> 
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
        <script>
        const dailyData = <?php echo json_encode($dailyData); ?>;
        dailyChart("dailyChart", dailyData);
        </script>
        <script src="assets/script.js"></script>
    </body>
</html>