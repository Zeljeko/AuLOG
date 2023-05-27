<?php
	require 'functions.php';	

	// start charging transaction
    if(isset($_POST["start_charging_session"])) { 
            $student_number = $_POST['student_number'];
            $rfid_tag = $_POST['rfid_tag'];
            $tag_number = $_POST['tag_number'];
            startChargingSession($student_number, $rfid_tag, $tag_number);
    }
?>