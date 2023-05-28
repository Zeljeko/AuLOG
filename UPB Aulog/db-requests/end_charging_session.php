<?php
	require '../functions.php';	

	// end charging session
	if($_GET['log_id'] != NULL) { 
		$student_number = $_GET['student_number'];
		$log_id = $_GET['log_id'];
		$time_in = $_GET['time_in'];
		endChargingSession($student_number, $time_in, $log_id);
	}
?>