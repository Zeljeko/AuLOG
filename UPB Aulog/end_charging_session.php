<?php
	require 'functions.php';	

	// end charging session
	if($_GET['log_id'] != NULL) { 
		$log_id = $_GET['log_id'];
		$time_in = $_GET['time_in'];
		endChargingSession($time_in, $log_id);
	}
?>