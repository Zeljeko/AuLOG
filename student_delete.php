<?php
	require 'functions.php';	

	// delete student info
	if($_GET['student_number'] != NULL) {   
		$student_number = $_GET['student_number'];
		deleteStudent($student_number);
	}
?>