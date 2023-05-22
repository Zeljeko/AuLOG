<?php

	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "aulog_database";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $database);
	// Check connection

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}	

	// delete student info
	if($_GET['log_id'] != NULL) { // student number   
		$log_id = $_GET['log_id'];
		$sql = "DELETE FROM charging_log WHERE log_id = '$log_id'";
	}

	if (mysqli_query($conn, $sql)) {
		echo "<script type='text/javascript'>alert('Entry deleted.');
		window.location.href='log.php';</script>";
	}  else {
		echo "<script type='text/javascript'>alert('Cannot delete entry.');
		window.location.href='log.php';</script>";
	}
	
	// close connection
	mysqli_close($conn);
?>