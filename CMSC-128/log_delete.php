<?php
	require 'functions.php';	

	// delete charging log
	if($_GET['log_id'] != NULL) {   
		$log_id = $_GET['log_id'];
		deleteChargingLog($log_id);
	}
?>