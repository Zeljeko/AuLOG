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

// add student info
function addStudent($firstName, $lastName, $student_number, $email) {
    // Connect to the database
    $conn = connect();

    // Prepare the INSERT statement
    $charge_consumed = 0;
    $stmt = $conn->prepare("INSERT INTO student (first_name, last_name, student_number, email, charge_consumed) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $firstName, $lastName, $student_number, $email, $charge_consumed);

    // Execute the query
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

    // Prepare the DELETE statement
    $stmt = $conn->prepare("DELETE FROM student WHERE student_number = ?");
    $stmt->bind_param("s",$student_number);

    // Execute the query
    $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    echo "<script type='text/javascript'>alert('Entry deleted. Redirecting you back to the admin page.');
                window.location.href='student.php';</script>";
}

// edit student info
function editStudent($first_name, $last_name, $student_number, $email, $charge_consumed, $condition) {
    // Connect to the database
    $conn = connect();

    // Prepare the UPDATE statement
    $stmt = $conn->prepare("UPDATE student
    SET first_name = ?, last_name = ?, student_number = ?, email = ?, charge_consumed = ?
    WHERE student_number = ?");
    $stmt->bind_param("ssssis",$first_name, $last_name, $student_number, $email, $charge_consumed, $condition);

    // Execute the query
    $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    echo "<script type='text/javascript'>alert('Edit successful. Redirecting you back to the admin page.');
                window.location.href='student.php';</script>";
}

// student info edit form
function editStudentForm($first_name, $last_name, $student_number, $email, $charge_consumed) {
    $hours = intdiv($charge_consumed,60);
    $minutes = $charge_consumed % 60;

    // form heading i
    echo "<form action='student_edit.php' target='_self' method='post'>";
    echo "<table width='100%'>";
    echo "<thead>";
    echo "<tr>";
    echo "<td>First Name</td>";
    echo "<td>Second Name</td>";
    echo "<td>Student No.</td>";
    echo "<td>Email Address</td>";
    echo "</tr>";
    echo "</thead>";
    
    // input fields i
    echo "<tbody> <tr>";
    echo "<td> <input type='text' id='first_name' name='first_name' value='".$first_name."'/> </td>";
    echo "<td> <input type='text' id='last_name' name='last_name' value='".$last_name."'/> </td>";
    echo "<td> <input type='text' id='student_number' name='student_number' value='".$student_number."'/> </td>";
    echo "<td> <input type='text' id='email' name='email' value='".$email."'/> </td>";
    echo "</tr>";

    // form heading ii
    echo "<tr>";
    echo "<td>Hours</td>";
    echo "<td>Minutes</td>";
    echo "</tr>";

    // input fields ii
    echo "<tr>";
    echo "<td> <input type='number' id='hours' name='hours' value='".$hours."'/> </td>";
    echo "<td> <input type='number' id='minutes' name='minutes' value='".$minutes."'/> </td>";
    echo "</tr> </tbody>";
    echo "</table>";

    echo "<input type='hidden' id='condition' name='condition' value='".$student_number."'/>";

    // forward data to self
    echo "<br/><input type='submit' name='student_edit' formmethod='post' value='Apply'>";
    echo "</form>";
}

// create charging session
function startChargingSession($student_number) {
    // Connect to the database
    $conn = connect();

    // Get the current timestamp
    $time_in = date("Y-m-d H:i:s");

    // Prepare the INSERT statement
    $stmt = $conn->prepare("INSERT INTO charging_log (student_number, time_in) VALUES (?, ?)");
    $stmt->bind_param("ss", $student_number, $time_in);

    // Execute the query
    $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

// terminate charging session
function endChargingSession($log_id) {
    // Connect to the database
    $conn = connect();

    // Get the current timestamp
    $time_out = date("Y-m-d H:i:s");

    // Prepare the UPDATE statement to end the charging session
    $stmt = $conn->prepare("UPDATE charging_log SET time_out = ? WHERE log_id = ?");
    $stmt->bind_param("si", $time_out, $log_id);

    // Execute the query to end the charging session
    $stmt->execute();
    $stmt->close();

    // Calculate the charge consumed by the student
    $stmt = $conn->prepare("SELECT (TIMESTAMPDIFF(MINUTE, time_in, time_out) + charge_consumed)
    FROM student JOIN charging_log ON student.student_number = charging_log.student_number WHERE log_id = ?");
    $stmt->bind_param("i", $log_id);
    $stmt->execute();
    $stmt->bind_result($charge_consumed);
    $stmt->fetch();
    $stmt->close();

    // Update the total_charge_time in the student table
    $stmt = $conn->prepare("UPDATE student SET charge_consumed = ? WHERE student_number = ?");
    $stmt->bind_param("is", $charge_consumed, $student_number);
    $stmt->execute();
    $stmt->close();

    // Close the connection
    $conn->close();
}

// output charging logs
function getChargingLog() {
    // Connect to the database
    $conn = connect();

    // Prepare the SELECT statement
    $stmt = $conn->prepare("SELECT * FROM charging_log");

    // Execute the query
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
function getStudentLog($studentId) {
    // Connect to the database
    $conn = connect();

    // Prepare the SELECT statement
    $stmt = $conn->prepare("SELECT * FROM charging_log WHERE student_number = ?");
    $stmt->bind_param("s", $student_number);

    // Execute the query
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

    // Prepare the INSERT statement
    $stmt = $conn->prepare("INSERT INTO charging_log (log_id, tag_number, student_number, time_in, time_out, state) 
    VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issisi", $log_id, $tag_number, $student_number, $time_in, $time_out, $state);

    
    // Execute the query
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

    // Prepare the DELETE statement
    $stmt = $conn->prepare("DELETE FROM charging_log WHERE log_id = ?");
    $stmt->bind_param("s",$log_id);

    // Execute the query
    $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    echo "<script type='text/javascript'>alert('Entry deleted. Redirecting you back to the admin page.');
                window.location.href='log.php';</script>";
}

// edit charging log
function editChargingLog($log_id, $tag_number, $student_number, $time_in, $time_out, $state, $condition) {
    if($state == 'inactive')
        $log_state = 0;
    else
        $log_state = 1;

    // Connect to the database
    $conn = connect();

    // Prepare the UPDATE statement
    $stmt = $conn->prepare("UPDATE charging_log
    SET log_id = ?, tag_number = ?, student_number = ?, time_in = ?, time_out = ?, state = ?
    WHERE log_id = ?");
    $stmt->bind_param("iisssii",$log_id, $tag_number, $student_number, $time_in, $time_out, $log_state, $condition);

    // Execute the query
    $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    echo "<script type='text/javascript'>alert('Edit successful. Redirecting you back to the admin page.');
                window.location.href='log.php';</script>";
}

// charging log edit form
function editChargingLogForm($log_id, $tag_number, $student_number, $time_in, $time_out, $state) {
    if($state == '0')
        $log_state = "inactive";
    else
        $log_state = 'active';

    // form heading i
    echo "<form action='log_edit.php' target='_self' method='post'>";
    echo "<table width='100%'>";
    echo "<thead>";
    echo "<tr>";
    echo "<td>LOG ID</td>";
    echo "<td>Tag No.</td>";
    echo "<td>Student No.</td>";
    echo "</tr>";
    echo "</thead>";
                        
    // input fields i
    echo "<tbody> <tr>";
    echo "<td> <input type='text' id='log_id' name='log_id' value='".$log_id."'/> </td>";
    echo "<td> <input type='int' id='tag_number' name='tag_number' value='".$tag_number."'/> </td>";
    echo "<td> <input type='text' id='student_number' name='student_number' value='".$student_number."'/> </td>";
    echo "</tr>";

    // form heading ii
    echo "<tr>";
    echo "<td>Time in</td>";
    echo "<td>Time out</td>";
    echo "<td>State</td>";
    echo "</tr>";

    // input fields ii
    echo "<tr>";
    echo "<td> <input type='text' id='time_in' name='time_in' value='".$time_in."'/> </td>";
    echo "<td> <input type='text' id='time_out' name='time_out' value='".$time_out."'/> </td>";
    echo "<td> <input type='text' id='state' name='state' value='".$log_state."'/> </td>";
    echo "</tr> </tbody>";
    echo "</table>";

    echo "<input type='hidden' id='condition' name='condition' value='".$log_id."'/>";

    // forward data to self
    echo "<br/><input type='submit' name='log_edit' formmethod='post' value='Apply'>";
    echo "</form>";
}

function getRemainingCharge($charge_consumed) {
    // Connect to the database
    $conn = connect();

    $sql = "SELECT value FROM constants WHERE constant_id = 'charging_time'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));

    // close connection
    $conn->close();

    return $result['value'] - $charge_consumed;
}

function getStudentEmail($student_number) {
    // Connect to the database
    $conn = connect();

    // Prepare the SELECT statement
    $stmt = $conn->prepare("SELECT email FROM student WHERE student_number = ?");
    $stmt->bind_param("i", $student_number);

    // Execute the query
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

function sendEmailToStudent($email, $charge_consumed) {
    $apiKey = 'mailgun_api_key';
    $domain = 'mailgun_domain';
    $fromEmail = 'sender_email@example.com';
    $fromName = 'Library yowzzzz';

    // calculate remaining time
    $remaining_time = getRemainingCharge($charge_consumed);

    $subject = 'Remaining Charging Time';
    $message = "Dear student,\n\nYou have $remaining_time minutes remaining for your charging session.\n\nBest regards,\nYour Library";

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
