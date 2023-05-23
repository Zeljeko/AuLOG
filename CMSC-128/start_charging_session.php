<?php
	require 'functions.php';	

	// start charging transaction
    if(isset($_POST["start_charging_session"])) { 
            $student_number = $_POST['student_number'];
            $tag_number = $_POST['tag_number'];
            startChargingSession($student_number, $tag_number);
    }
?>