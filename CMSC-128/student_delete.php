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
	if($_GET['student_number'] != NULL) { // student number   
		$student_number = $_GET['student_number'];
		$sql = "DELETE FROM student WHERE student_number = '$student_number'";
	}

	if (mysqli_query($conn, $sql)) {
		echo "<script type='text/javascript'>alert('Entry deleted.');
		window.location.href='student.php';</script>";
	}  else {
		echo "<script type='text/javascript'>alert('Cannot delete entry.');
		window.location.href='student.php';</script>";
	}
	
	// close connection
	mysqli_close($conn);
?>