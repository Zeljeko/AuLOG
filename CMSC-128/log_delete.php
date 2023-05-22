<?php
	
	require 'functions.php';	

	// delete log info
	if($_GET['log_id'] != NULL) { // log id   
		$log_id = $_GET['log_id'];
		deleteChargingLog($log_id);
	}
?>