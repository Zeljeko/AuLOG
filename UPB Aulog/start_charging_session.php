<?php
	require 'functions.php';	

	// start charging transaction
    if(isset($_POST["start_charging_session"])) { 
            $rfid_tag = $_POST['rfid_tag'];
            $tag_number = $_POST['tag_number'];
            startChargingSession($rfid_tag, $tag_number);
    }
?>