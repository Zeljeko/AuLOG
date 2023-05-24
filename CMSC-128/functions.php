<?php

    // database connection function
    function connect() {
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

        return $conn;
    }

    // output single student info
    function getStudent($student_number) {
        // Connect to the database
        $conn = connect();

        // Prepare, bind, and execute the SELECT statement
        $stmt = $conn->prepare("SELECT * FROM student WHERE student_number = ?");
        $stmt->bind_param("s", $student_number);
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        // Fetch and return the rows
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        return $rows;
    }

    // output student info
    function getStudents() {
        // Connect to the database
        $conn = connect();

        // Prepare and execute the SELECT statement
        $stmt = $conn->prepare("SELECT * FROM student");
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        // Fetch and return the rows
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        return $rows;
    }

    // output active students
    function getActiveStudents() {
        // Connect to the database
        $conn = connect();

        // Prepare and execute the SELECT statement
        $stmt = $conn->prepare("SELECT student.student_number, rfid_tag, first_name, last_name, log_id, time_in,
            TIMESTAMPDIFF(MINUTE, time_in, CURRENT_TIMESTAMP()) AS difference FROM student JOIN charging_log
            ON student.student_number = charging_log.student_number
            WHERE state = 1");
        $stmt->execute();
    
        // Get the result set
        $result = $stmt->get_result();
    
        // Fetch and return the rows
        $rows = $result->fetch_all(MYSQLI_ASSOC);
    
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    
        return $rows;
    }

    // add student info
    function addStudent($rfid_tag, $first_name, $last_name, $student_number, $email) {
        // Connect to the database
        $conn = connect();

        // Prepare, bind, and execute the INSERT statement
        $charge_consumed = 0;
        $stmt = $conn->prepare("INSERT INTO student (rfid_tag, first_name, last_name, student_number, email, charge_consumed)
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $rfid_tag, $first_name, $last_name, $student_number, $email, $charge_consumed);
        $stmt->execute();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        echo "<script type='text/javascript'>alert('Entry added. Redirecting you back to the admin page.');
            window.location.href='student.php';</script>";
    }

    // delete student info
    function deleteStudent($student_number) {
        // Connect to the database
        $conn = connect();

        // Prepare, bind, and execute the DELETE statement
        $stmt = $conn->prepare("DELETE FROM student WHERE student_number = ?");
        $stmt->bind_param("s",$student_number);
        $stmt->execute();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        echo "<script type='text/javascript'>alert('Entry deleted. Redirecting you back to the admin page.');
            window.location.href='student.php';</script>";
    }

    // edit student info
    function editStudent($rfid_tag, $first_name, $last_name, $student_number, $email, $charge_consumed, $condition) {
        // Connect to the database
        $conn = connect();

        // Prepare, bind, and execute the UPDATE statement
        $stmt = $conn->prepare("UPDATE student
            SET rfid_tag = ?, first_name = ?, last_name = ?, student_number = ?, email = ?, charge_consumed = ?
            WHERE student_number = ?");
        $stmt->bind_param("sssssis", $rfid_tag, $first_name, $last_name, $student_number, $email, $charge_consumed, $condition);
        $stmt->execute();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        echo "<script type='text/javascript'>alert('Edit successful. Redirecting you back to the admin page.');
                window.location.href='student.php';</script>";
    }

    // create charging session
    function startChargingSession($rfid_tag, $tag_number) {
        // Connect to the database
        $conn = connect();

        $constant_id = 'next_available_id';

        // Prepare and execute the SELECT statement (next available id)
        $stmt = $conn->prepare("SELECT value FROM constants
            WHERE constant_id = ?");
        $stmt->bind_param("s",$constant_id);
        $stmt->execute();

        // Get the result set, fetch the rows
        $result = $stmt->get_result();
        $rows = $result->fetch_assoc();
        $next_available_id = $rows['value'];

        // get student number
        $student_number = getStudentNumber($rfid_tag);

        // representation of active state
        $active_state = 1;

        // Prepare, bind, and execute the INSERT statement (start charging session)
        $stmt = $conn->prepare("INSERT INTO charging_log (log_id, student_number, tag_number, time_in, state)
            VALUES (?, ?, ?, CURRENT_TIMESTAMP(), ?)");
        $stmt->bind_param("isii", $next_available_id, $student_number, $tag_number, $active_state);
        $stmt->execute();

        // increment next_available_id
        $next_available_id = $next_available_id + 1;

        // Prepare, bind, and execute the UPDATE statement (update next_available_id)
        $stmt = $conn->prepare("UPDATE constants SET value = ? WHERE constant_id = ?");
        $stmt->bind_param("is", $next_available_id, $constant_id);
        $stmt->execute();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        echo "<script type='text/javascript'>alert('$student_number');
            window.location.href='main.php';</script>";
    }

    // terminate charging session
    function endChargingSession($time_in, $log_id) {
        // Connect to the database
        $conn = connect();

        // representation of inactive state
        $inactive_state = 0;

        // Prepare, bind, and execute the UPDATE statement (terminate charging session)
        $stmt = $conn->prepare("UPDATE charging_log SET time_in = ?, time_out = CURRENT_TIMESTAMP(),
            state = ? WHERE log_id = ?");
        $stmt->bind_param("sii", $time_in, $inactive_state, $log_id);
        $stmt->execute();
        $stmt->close();

        // Prepare, bind, and execute the SELECT STATEMENT (calculate remaining charging time)
        $stmt = $conn->prepare("SELECT student.student_number,
            (TIMESTAMPDIFF(MINUTE, time_in, time_out) + charge_consumed) AS consumed
            FROM student JOIN charging_log ON student.student_number = charging_log.student_number
            WHERE log_id = ?");
        $stmt->bind_param("i", $log_id);
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        // Fetch and return the rows
        $rows = $result->fetch_assoc();

        // Assign fetched data to variables
        $consumed = $rows['consumed'];
        $student_number = $rows['student_number'];

        // Prepare, bind, and execute the UPDATE statement (update remaining charge time)
        $stmt = $conn->prepare("UPDATE student SET charge_consumed = ? WHERE student_number = ?");
        $stmt->bind_param("is", $consumed, $student_number);
        $stmt->execute();
        
        $email = getStudentEmail($student_number);
        $remaining_time = getRemainingCharge($student_number);

        $response = sendEmailToStudent($email, $remaining_time);

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        echo "<script type='text/javascript'>alert('".$response."');
            window.location.href='main.php';</script>";
    }

    // output charging logs
    function getChargingLog() {
        // Connect to the database
        $conn = connect();

        // Prepare and execute the SELECT statement
        $stmt = $conn->prepare("SELECT * FROM charging_log");
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        // Fetch and return the rows
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        return $rows;
    }

    // output student charging logs
    function getStudentLog($student_number) {
        
        // Connect to the database
        $conn = connect();

        // Prepare, bind, and execute the SELECT statement
        $stmt = $conn->prepare("SELECT * FROM charging_log WHERE student_number = ?");
        $stmt->bind_param("s", $student_number);
        $stmt->execute();
        
        // Get the result set
        $result = $stmt->get_result();

        // Fetch and return the rows
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        
        // Close the statement and connection
        $stmt->close();
        $conn->close();

        return $rows;
    }

    // add charging log
    function addChargingLog($log_id, $tag_number, $student_number, $time_in, $time_out, $state) {
        // Connect to the database
        $conn = connect();

        // Prepare, bind, and execute the INSERT statement
        $stmt = $conn->prepare("INSERT INTO charging_log (log_id, tag_number, student_number, time_in, time_out, state) 
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issisi", $log_id, $tag_number, $student_number, $time_in, $time_out, $state);
        $stmt->execute();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        echo "<script type='text/javascript'>alert('Entry added. Redirecting you back to the admin page.');
            window.location.href='log.php';</script>";
    }

    // delete charging log
    function deleteChargingLog($log_id) {
        // Connect to the database
        $conn = connect();

        // Prepare, bind, and execute the DELETE statement
        $stmt = $conn->prepare("DELETE FROM charging_log WHERE log_id = ?");
        $stmt->bind_param("s",$log_id);
        $stmt->execute();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        echo "<script type='text/javascript'>alert('Entry deleted. Redirecting you back to the admin page.');
                window.location.href='log.php';</script>";
    }

    // edit charging log
    function editChargingLog($log_id, $tag_number, $student_number, $time_in, $time_out, $state, $condition) {
        // convert representaion of state to binary
        if($state == 'inactive')
            $log_state = 0;
        else
            $log_state = 1;

        // Connect to the database
        $conn = connect();

        // Prepare, bind, and execute the UPDATE statement
        $stmt = $conn->prepare("UPDATE charging_log
            SET log_id = ?, tag_number = ?, student_number = ?, time_in = ?, time_out = ?, state = ?
            WHERE log_id = ?");
        $stmt->bind_param("iisssii",$log_id, $tag_number, $student_number, $time_in, $time_out, $log_state, $condition);
        $stmt->execute();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        echo "<script type='text/javascript'>alert('Edit successful. Redirecting you back to the admin page.');
            window.location.href='log.php';</script>";
    }

    // get remaining charge
    function getRemainingCharge($student_number) {
        // Connect to the database
        $conn = connect();

        // Prepare, bind, and execute the SELECT statement
        $stmt = $conn->prepare("SELECT charge_consumed, value FROM student JOIN constants
            WHERE student_number = ?");
        $stmt->bind_param("s",$student_number);
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        // Fetch and return the rows
        $rows = $result->fetch_assoc();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        return $rows['value'] - $rows['charge_consumed'];
    }

    // get student email
    function getStudentEmail($student_number) {
        // Connect to the database
        $conn = connect();

        // Prepare, bind, and execute the SELECT statement
        $stmt = $conn->prepare("SELECT email FROM student WHERE student_number = ?");
        $stmt->bind_param("s", $student_number);
        $stmt->execute();

        // Bind the result to a variable
        $stmt->bind_result($email);

        // Fetch the result
        $stmt->fetch();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        // Return the student's email
        return $email;
    }

    // get student number
    function getStudentNumber($rfid_tag) {
        // Connect to the database
        $conn = connect();

        // Prepare, bind, and execute the SELECT statement
        $stmt = $conn->prepare("SELECT student_number FROM student WHERE rfid_tag = ?");
        $stmt->bind_param("s", $rfid_tag);
        $stmt->execute();

        // Bind the result to a variable
        $stmt->bind_result($student_number);

        // Fetch the result
        $stmt->fetch();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        // Return the student's email
        return $student_number;
    }

    function sendEmailToStudent($email, $remaining_time) {
        $apiKey = 'mailgun_api_key';
        $domain = 'mailgun_domain';
        $fromEmail = 'sample@gmail.com';
        $fromName = 'Benjamin';

        $subject = 'Remaining Charging Time';
        $message = "Dear student,\n\nYou have $remaining_time minutes remaining for
            your charging session.\n\nBest regards,\nYour Library";

        // Prepare the email parameters
        $params = array(
            'from' => "$fromName <$fromEmail>",
            'to' => $email,
            'subject' => $subject,
            'text' => $message
        );

        // Send the email using Mailgun API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.mailgun.net/v3/$domain/messages");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "api:$apiKey");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
?>