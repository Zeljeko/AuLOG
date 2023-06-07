<?php
	require '../functions.php';	
    $postdata = $_POST['student_number'];
    echo getRemainingCharge($postdata);
?>