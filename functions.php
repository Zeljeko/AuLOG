<?php
    //For email sending
    require 'includes/PHPMailer.php';
    require 'includes/SMTP.php';
    require 'includes/Exception.php';
    //Define name spaces
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

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
        if($student_number == "")
            return getStudents();
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
        $stmt = $conn->prepare("SELECT * FROM student ORDER BY first_name, last_name ASC");
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
    function getActiveStudentsAjax() {
        // Connect to the database
        $conn = connect();

        // Prepare and execute the SELECT statement;
        $query = "SELECT student.student_number, tag_number, rfid_tag, first_name, last_name, college, log_id, time_in
        FROM student JOIN charging_log
        ON student.student_number = charging_log.student_number
        WHERE state = 1 ORDER BY time_in ASC";

        $stmt = $conn->prepare($query);
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        $rows = $result->fetch_all(MYSQLI_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($rows);
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }

    function getActiveStudents() {
        // Connect to the database
        $conn = connect();

        // Prepare and execute the SELECT statement;
        $stmt = $conn->prepare("SELECT student.student_number, tag_number, rfid_tag, first_name, last_name, college, log_id, time_in
            FROM student JOIN charging_log
            ON student.student_number = charging_log.student_number
            WHERE state = 1 ORDER BY time_in ASC");
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

    // get student number by rfid tag
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

    // add student info
    function addStudent($rfid_tag, $first_name, $last_name, $student_number, $college, $email) {
        // Connect to the database
        $conn = connect();

        // Prepare, bind, and execute the INSERT statement
        $charge_consumed = 0;
        $stmt = $conn->prepare("INSERT INTO student (rfid_tag, first_name, last_name, student_number, college, email, charge_consumed)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $rfid_tag, $first_name, $last_name, $student_number, $college, $email, $charge_consumed);
        $stmt->execute();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        echo "<script type='text/javascript'>alert('Entry added. Redirecting you back to the Student Information page.');
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

        echo "<script type='text/javascript'>alert('Entry deleted. Redirecting you back to the Student Information page.');
            window.location.href='../student.php';</script>";
    }

    // edit student info
    function editStudent($rfid_tag, $first_name, $last_name, $student_number, $college, $email, $charge_consumed, $condition) {
        // Connect to the database
        $conn = connect();

        // Prepare, bind, and execute the UPDATE statement
        $stmt = $conn->prepare("UPDATE student
            SET rfid_tag = ?, first_name = ?, last_name = ?, student_number = ?, college = ?, email = ?, charge_consumed = ?
            WHERE student_number = ?");
        $stmt->bind_param("ssssssis", $rfid_tag, $first_name, $last_name, $student_number, $college, $email, $charge_consumed, $condition);
        $stmt->execute();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        echo "<script type='text/javascript'>alert('Edit successful. Redirecting you back to the Student Information page.');
                window.location.href='student.php';</script>";
    }

    function editTagNumber($log_id, $tag_number) {
        // Connect to the database
        $conn = connect();

        // Prepare, bind, and execute the SELECT statement
        $stmt = $conn->prepare("SELECT time_in FROM charging_log WHERE log_id = ?");
        $stmt->bind_param("i",$log_id);
        $stmt->execute();

        // Get the result set, fetch and return the rows
        $result = $stmt->get_result();
        $rows = $result->fetch_assoc();
        $time_in = $rows['time_in'];

        // Prepare, bind, and execute the UPDATE statement
        $stmt = $conn->prepare("UPDATE charging_log SET time_in = ?, tag_number = ? WHERE log_id = ?");
        $stmt->bind_param("sii", $time_in, $tag_number, $log_id);
        $stmt->execute();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        echo "<script type='text/javascript'>alert('Edit successful. Redirecting you back to the dashboard.');
                window.location.href='main.php';</script>";
    }

    // create charging session
    function startChargingSession($student_number, $rfid_tag, $tag_number) {
        // Connect to the database
        $conn = connect();

        // get student number
        if($rfid_tag != NULL)
            $student_number = getStudentNumber($rfid_tag);

        // representation of active state
        $active_state = 1;

        // Prepare, bind, and execute the SELECT statement (get log_id and charging_log)
        $stmt = $conn->prepare("SELECT log_id, time_in FROM charging_log WHERE student_number = ? AND state = ?");
        $stmt->bind_param("si",$student_number, $active_state);
        $stmt->execute();
    
        // Get the result set
        $result = $stmt->get_result();
    
        // Fetch and return the rows
        $rows = $result->fetch_assoc();

        if($rows) {
            endChargingSession($student_number, $rows['time_in'], $rows['log_id']);

            // Close the statement and connection
            $stmt->close();
            $conn->close();
        } else if($student_number != null) {
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

            echo "<script type='text/javascript'>alert('Session added');
                window.location.href='../main.php';
                </script>";
        } else {
            echo "<script type='text/javascript'>alert('Invalid entry');
                window.location.href='../main.php';</script>";
        }
    }

    // terminate charging session
    function endChargingSession($student_number, $time_in, $log_id) {
        // Connect to the database
        $conn = connect();

        // representation of inactive state
        $inactive_state = 0;

        // Prepare, bind, and execute the UPDATE statement (terminate charging session)
        $stmt = $conn->prepare("UPDATE charging_log SET time_in = ?, time_out = CURRENT_TIMESTAMP(),
            state = ? WHERE log_id = ?");
        $stmt->bind_param("sii", $time_in, $inactive_state, $log_id);
        $stmt->execute();

        // calculate charge consumed 
        $charge_consumed = getTimeElapsed($log_id);
        $hours_consumed = intdiv($charge_consumed, 60);
        $minutes_consumed = $charge_consumed % 60;

        $response = sendEmailChargingStatus($student_number);
        echo "<script type='text/javascript'>alert('$response Terminated session. Consumed: $hours_consumed hour/s, $minutes_consumed minute/s');
            window.location.href='../main.php';</script>";
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

    // get time elapsed
    function getTimeElapsed($log_id) {
        // Connect to the database
        $conn = connect();

        // Prepare, bind, and execute the SELECT statement
        $stmt = $conn->prepare("SELECT state FROM charging_log WHERE log_id = ?");
        $stmt->bind_param("i",$log_id);
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        // Fetch and return the rows
        $rows = $result->fetch_assoc();

        if($rows['state'] == 1) {
            // Prepare, bind, and execute the SELECT statement
            $stmt = $conn->prepare("SELECT TIMESTAMPDIFF(MINUTE, time_in, CURRENT_TIMESTAMP()) AS time_elapsed
            FROM charging_log WHERE log_id = ?");
            $stmt->bind_param("i",$log_id);
            $stmt->execute();
        } else {
            // Prepare, bind, and execute the SELECT statement
            $stmt = $conn->prepare("SELECT TIMESTAMPDIFF(MINUTE, time_in, time_out) AS time_elapsed
            FROM charging_log WHERE log_id = ?");
            $stmt->bind_param("i",$log_id);
            $stmt->execute();
        }

        // Get the result set
        $result = $stmt->get_result();

        // Fetch and return the rows
        $rows = $result->fetch_assoc();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        return $rows['time_elapsed'];
    }

    function generateHTMLTableFromRecords($records) {
        // Create an empty string to hold the HTML table
        $htmlTable = '';
    
        // Check if there are any records
        if (count($records) > 0) {
            // Start the HTML table
            $htmlTable .= '<table>';
            $htmlTable .= '<tr><th>Log ID</th><th>Student Number</th><th>Time In</th><th>Time Out</th><th>Charge Consumed</th></tr>';
    
            // Loop through each record and generate table rows
            foreach ($records as $record) {
                // compute hours and minutes consumed
                if($record['state'] != 0)
                    continue;
                $hours_consumed = intdiv($record['consumed'], 60);
                $minutes_consumed = $record['consumed'] % 60;


                $htmlTable .= '<tr>';
                $htmlTable .= '<td>' . $record['log_id'] . '</td>';
                $htmlTable .= '<td>' . $record['student_number'] . '</td>';
                $htmlTable .= '<td>' . $record['time_in'] . '</td>';
                $htmlTable .= '<td>' . $record['time_out'] . '</td>';
                $htmlTable .= '<td>' . $hours_consumed . ' hour/s and  ' . $minutes_consumed . ' minute/s</td>';
                $htmlTable .= '</tr>';
            }
    
            // Close the HTML table
            $htmlTable .= '</table>';
        } else {
            $htmlTable = 'No records found.';
        }
    
        // Return the HTML table string
        return $htmlTable;
    }

    function generateRemainingChargeHTML($student_number) {
        // Get the remaining charge for the student
        $hours = intdiv(getRemainingCharge($student_number), 60);
        $minutes = getRemainingCharge($student_number) % 60;
    
        // Create the HTML string
        $html = '<p>Dear student, your remaining charging hours are:</p>';
        $html .= '<h1>' . $hours . ' hours ' . 'and '. $minutes .' minutes '. '</h1>';
        $html .= '<p>Thank you.</p>';
    
        return $html;
    }
    
    function sendEmailChargingStatus($student_number){
    //Create instance of PHPMailer
        $mail = new PHPMailer();
    //Set mailer to use smtp
        $mail->isSMTP();
    //Define smtp host
        $mail->Host = "smtp.gmail.com";
    //Enable smtp authentication
        $mail->SMTPAuth = true;
    //Set smtp encryption type (ssl/tls)
        $mail->SMTPSecure = "tls";
    //Port to connect smtp
        $mail->Port = "587";
    //Set gmail username
        //Use own email
        $mail->Username = "rpquinones@up.edu.ph";
    //Set gmail password
        // Turn on 2-factor auth on your/organization email
        // Go here https://myaccount.google.com/apppasswords
        // Copy paste app password to this string
        $mail->Password = "sgreoylcwheqkoad";
    //Email subject
        $mail->Subject = "Charging Records and Remaining Time";
    //Set sender email
        $mail->setFrom('someone@up.edu.ph');
    //Enable HTML
        $mail->isHTML(true);
    //Email body
        $records = getStudentLog($student_number);
        $HTMLremainingCharge = generateRemainingChargeHTML($student_number);
        $HTMLrecords = generateHTMLTableFromRecords($records);
        //Concatenate
        $emailBody = $HTMLremainingCharge . $HTMLrecords;
        $mail->Body = $emailBody;
    //Add recipient
        $student_email = getStudentEmail($student_number);
        $mail->addAddress($student_email);
    //Finally send email
        if ( $mail->send() ) {
            return "Email Sent Successfully.";
        }else {
            return "EMAIL NOT SENT.";
        }
    //Closing smtp connection
        $mail->smtpClose();
    }

    // output charging logs
    function getChargingLog() {
        // Connect to the database
        $conn = connect();

        // Prepare and execute the SELECT statement
        $stmt = $conn->prepare("SELECT * FROM charging_log ORDER BY time_in, time_out ASC");
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
        if($student_number == "")
            return getChargingLog();
        // Connect to the database
        $conn = connect();

        // Prepare, bind, and execute the SELECT statement
        $stmt = $conn->prepare("SELECT log_id, student_number, tag_number, time_in, time_out, state,
            TIMESTAMPDIFF(MINUTE, time_in, time_out) AS consumed
            FROM charging_log WHERE student_number = ? ORDER BY time_in, time_out ASC");
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

    // reset charging time and clear history
    function resetHistory() {
        // Connect to the database
        $conn = connect();

        // representation of old transaction
        $old_state = -1;

        // Prepare and execute the DELETE statement
        $stmt = $conn->prepare("UPDATE charging_log SET state = ?");
        $stmt->bind_param("i", $old_state);
        $stmt->execute();

        // Prepare, bind, and execute the UPDATE statement
        $stmt = $conn->prepare("UPDATE student SET charge_consumed = 0");
        $stmt->execute();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        echo "<script type='text/javascript'>alert('Reset successful. Redirecting you back to the admin page.');
                window.location.href='../log.php';</script>";
    }

    // get maximum charge time
    function getMaximumChargingTime() {
        // Connect to the database
        $conn = connect();

        // constant id
        $constant_id = 'charging_time';

        // Prepare, bind, and execute the SELECT statement
        $stmt = $conn->prepare("SELECT value FROM constants WHERE constant_id = ?");
        $stmt->bind_param("i", $constant_id);
        $stmt->execute();

        // Bind the result to a variable
        $stmt->bind_result($charging_time);

        // Fetch the result
        $stmt->fetch();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        // Return the student's email
        return $charging_time;
    }

    // edit maximum charging time
    function editMaximumChargingTime($charging_time) {
        // Connect to the database
        $conn = connect();

        // constant id
        $constant_id = 'charging_time';

        // Prepare, bind, and execute the UPDATE statement
        $stmt = $conn->prepare("UPDATE constants SET value = ?
        WHERE constant_id = ?");
        $stmt->bind_param("is", $charging_time, $constant_id);
        $stmt->execute();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        echo "<script type='text/javascript'>alert('Edit successful. Redirecting you back to the admin page.');
                window.location.href='config.php';</script>";
    }

    // get numbe of tags
    function getNumberOfTags() {
        // Connect to the database
        $conn = connect();

        // constant id
        $constant_id = 'number_of_tags';

        // Prepare, bind, and execute the SELECT statement
        $stmt = $conn->prepare("SELECT value FROM constants WHERE constant_id = ?");
        $stmt->bind_param("s", $constant_id);
        $stmt->execute();

        // Bind the result to a variable
        $stmt->bind_result($number_of_tags);

        // Fetch the result
        $stmt->fetch();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        // Return the number of tags
        return $number_of_tags;
    }

    // edit number of tags
    function editNumberOfTags($number_of_tags) {
        // Connect to the database
        $conn = connect();

        // constant id
        $constant_id = 'number_of_tags';

        // Prepare, bind, and execute the UPDATE statement
        $stmt = $conn->prepare("UPDATE constants SET value = ?
        WHERE constant_id = ?");
        $stmt->bind_param("is", $number_of_tags, $constant_id);
        $stmt->execute();

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        echo "<script type='text/javascript'>alert('Edit successful. Redirecting you back to the admin page.');
                window.location.href='config.php';</script>";
    }

    function generateDailyReport() {
        $conn = connect();
    
        // Fetch the number of hours used each day for the past 30 days
        $sql = "SELECT DATE(time_in) AS day, SUM(TIMESTAMPDIFF(MINUTE, time_in, time_out)) AS total_minutes 
                FROM charging_log 
                WHERE time_in >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                GROUP BY DATE(time_in)";
        $result = $conn->query($sql);
    
        // Store the results in an array
        $reportData = array();
    
        // Get the past 30 days as an array of date strings
        $past30Days = array();
        for ($i = 0; $i < 30; $i++) {
            $past30Days[] = date('d', strtotime("-$i days"));
        }
    
        // Initialize report data with zero hours for all past 30 days
        foreach ($past30Days as $day) {
            $reportData[$day] = 0;
        }
    
        // Fill in the actual hours from the query results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $date = $row['day'];
                $day = date('d', strtotime($date));
                $totalMinutes = $row['total_minutes'];
                $totalHours = floor($totalMinutes / 60); // Convert minutes to hours
    
                // Store the day and total hours in the report data array
                $reportData[$day] = $totalHours;
            }
        }
        return $reportData;
    }
    
    function generateWeeklyReport() {
        $conn = connect();
    
        // Fetch the number of hours used each week
        $sql = "SELECT WEEK(time_in) AS week, SUM(TIMESTAMPDIFF(MINUTE, time_in, time_out)) AS total_minutes 
                FROM charging_log 
                GROUP BY WEEK(time_in)";
        $result = $conn->query($sql);
    
        // Store the results in an array
        $reportData = array();
    
        // Get the current year
        $currentYear = date('Y');
    
        // Initialize report data with zero hours for all weeks of the year
        for ($week = 1; $week <= 52; $week++) {
            $reportData[$week] = 0;
        }
    
        // Fill in the actual hours from the query results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $week = $row['week'];
                $totalMinutes = $row['total_minutes'];
                $totalHours = floor($totalMinutes / 60); // Convert minutes to hours
    
                // Store the week and total hours in the report data array
                $reportData[$week] = $totalHours;
            }
        }
    
        return $reportData;
    }
    
    
    function generateMonthlyReport() {
        $conn = connect();
    
        // Fetch the number of hours used each month
        $sql = "SELECT MONTH(time_in) AS month, SUM(TIMESTAMPDIFF(MINUTE, time_in, time_out)) AS total_minutes FROM charging_log GROUP BY MONTH(time_in)";
        $result = $conn->query($sql);
    
        // Store the results in an array
        $reportData = array();
    
        // Get the past 12 months as an array of month numbers
        $currentMonth = date('n'); // Get the current month number
        $past12Months = array();
        for ($i = 0; $i < 12; $i++) {
            $month = ($currentMonth - $i) > 0 ? ($currentMonth - $i) : (12 - abs($currentMonth - $i));
            $past12Months[] = $month;
        }
    
        // Initialize report data with zero hours for all past 12 months
        foreach ($past12Months as $month) {
            $reportData[$month] = 0;
        }
    
        // Fill in the actual hours from the query results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $month = $row['month'];
                $totalMinutes = $row['total_minutes'];
                $totalHours = floor($totalMinutes / 60); // Convert minutes to hours
    
                // Store the month and total hours in the report data array
                $reportData[$month] = $totalHours;
            }
        }
    
        return $reportData;
    }    

    function generateDailyReportCollege($collegeName) {
        $conn = connect();
    
        // Fetch the number of hours used each day for the past 30 days for the specified college
        $sql = "SELECT DATE(time_in) AS day, SUM(TIMESTAMPDIFF(MINUTE, time_in, time_out)) AS total_minutes 
                FROM charging_log 
                WHERE time_in >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                AND student_number IN (
                    SELECT student_number FROM student WHERE college = ?
                )
                GROUP BY DATE(time_in)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $collegeName);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Store the results in an array
        $reportData = array();
    
        // Get the past 30 days as an array of date strings
        $past30Days = array();
        for ($i = 0; $i < 30; $i++) {
            $past30Days[] = date('d', strtotime("-$i days"));
        }
    
        // Initialize report data with zero hours for all past 30 days
        foreach ($past30Days as $day) {
            $reportData[$day] = 0;
        }
    
        // Fill in the actual hours from the query results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $date = $row['day'];
                $day = date('d', strtotime($date));
                $totalMinutes = $row['total_minutes'];
                $totalHours = floor($totalMinutes / 60); // Convert minutes to hours
    
                // Store the day and total hours in the report data array
                $reportData[$day] = $totalHours;
            }
        }
        return $reportData;
    }

    function generateWeeklyReportCollege($collegeName) {
        $conn = connect();
    
        // Prepare the SQL statement with a placeholder for the college name
        $sql = "SELECT WEEK(time_in) AS week, SUM(TIMESTAMPDIFF(MINUTE, time_in, time_out)) AS total_minutes 
                FROM charging_log 
                JOIN student ON charging_log.student_number = student.student_number 
                WHERE student.college = ?
                GROUP BY WEEK(time_in)";
        $stmt = $conn->prepare($sql);
    
        // Bind the college name parameter to the prepared statement
        $stmt->bind_param("s", $collegeName);
    
        // Execute the prepared statement
        $stmt->execute();
    
        // Get the result
        $result = $stmt->get_result();
    
        // Store the results in an array
        $reportData = array();
    
        // Get the current year
        $currentYear = date('Y');
    
        // Initialize report data with zero hours for all weeks of the year
        for ($week = 1; $week <= 52; $week++) {
            $reportData[$week] = 0;
        }
    
        // Fill in the actual hours from the query results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $week = $row['week'];
                $totalMinutes = $row['total_minutes'];
                $totalHours = floor($totalMinutes / 60); // Convert minutes to hours
    
                // Store the week and total hours in the report data array
                $reportData[$week] = $totalHours;
            }
        }
    
        return $reportData;
    }

    function generateMonthlyReportCollege($collegeName) {
        $conn = connect();
    
        // Prepare the SQL statement with a placeholder for the college name
        $sql = "SELECT MONTH(time_in) AS month, SUM(TIMESTAMPDIFF(MINUTE, time_in, time_out)) AS total_minutes 
                FROM charging_log 
                JOIN student ON charging_log.student_number = student.student_number 
                WHERE student.college = ?
                GROUP BY MONTH(time_in)";
        $stmt = $conn->prepare($sql);
    
        // Bind the college name parameter to the prepared statement
        $stmt->bind_param("s", $collegeName);
    
        // Execute the prepared statement
        $stmt->execute();
    
        // Get the result
        $result = $stmt->get_result();
    
        // Store the results in an array
        $reportData = array();
    
        // Get the past 12 months as an array of month numbers
        $currentMonth = date('n'); // Get the current month number
        $past12Months = array();
        for ($i = 0; $i < 12; $i++) {
            $month = ($currentMonth - $i) > 0 ? ($currentMonth - $i) : (12 - abs($currentMonth - $i));
            $past12Months[] = $month;
        }
    
        // Initialize report data with zero hours for all past 12 months
        foreach ($past12Months as $month) {
            $reportData[$month] = 0;
        }
    
        // Fill in the actual hours from the query results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $month = $row['month'];
                $totalMinutes = $row['total_minutes'];
                $totalHours = floor($totalMinutes / 60); // Convert minutes to hours
    
                // Store the month and total hours in the report data array
                $reportData[$month] = $totalHours;
            }
        }
    
        return $reportData;
    }

    function generateCollegeReport() {
        // Replace 'connect()' with your database connection code
        $conn = connect();
    
        // Prepare the SQL statement to get total charging hours for each college
        $sql = "SELECT student.college AS college, SUM(TIMESTAMPDIFF(MINUTE, charging_log.time_in, charging_log.time_out)) AS total_minutes
                FROM charging_log
                JOIN student ON charging_log.student_number = student.student_number
                GROUP BY student.college";
        $result = $conn->query($sql);
    
        // Store the results in an array
        $reportData = array();
    
        // Fill in the actual hours from the query results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $college = $row['college'];
                $totalMinutes = $row['total_minutes'];
                $totalHours = floor($totalMinutes / 60); // Convert minutes to hours
    
                // Store the college and total hours in the report data array
                $reportData[$college] = $totalHours;
            }
        }
    
        return $reportData;
    }
    

    function downloadReports(){
        $conn = connect();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Query to retrieve data from the charging_log table
        $query = "SELECT * FROM charging_log";
        $result = $conn->query($query);
        
        if ($result->num_rows > 0) {
            // Open a new file for writing
            $file = fopen("charging_log_export.csv", "w");
        
            // Write the CSV header
            $header = array("log_id", "student_number", "tag_number", "time_in", "time_out", "state");
            fputcsv($file, $header);
        
            // Write data rows
            while ($row = $result->fetch_assoc()) {
                $data = array($row['log_id'], $row['student_number'], $row['tag_number'], $row['time_in'], $row['time_out'], $row['state']);
                fputcsv($file, $data);
            }
        
            // Close the file
            fclose($file);
        
            // Generate a downloadable link
            $fileUrl = "charging_log_export.csv";
            $fileName = basename($fileUrl);
            ?>
            <!-- Display the download button -->
            <a href="<?php echo $fileUrl; ?>" download="<?php echo $fileName; ?>">Download Charging Log CSV</a>
            <?php
        } else {
            echo "No data found.";
        }
        
        // Close the database connection
        $conn->close();
    }

    function exportChargingLogCSV()
{
    // Create a new database connection
    $conn = connect();

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to retrieve the charging log data including the student's college
    $query = "SELECT cl.log_id, cl.student_number, s.college, cl.time_in, cl.time_out,
    TIMESTAMPDIFF(MINUTE, cl.time_in, cl.time_out) AS consumed
              FROM charging_log cl
              INNER JOIN student s ON cl.student_number = s.student_number";

    // Execute the query
    $result = $conn->query($query);

    // Create the CSV file and write the data
    $file = fopen("reports.csv", 'w');

    // Write the CSV header
    fputcsv($file, ['Log ID', 'Student Number', 'College', 'Time In', 'Time Out', 'Charge Consumed']);

    // Write the data rows
    while ($row = $result->fetch_assoc()) {
        fputcsv($file, $row);
    }

    // Close the file
    fclose($file);

    // Close the database connection
    $conn->close();
}

function sendEmailReport($adminEmail)
{
    // Create an instance of PHPMailer
    $mail = new PHPMailer();

    // Set mailer to use SMTP
    $mail->isSMTP();

    // Define SMTP host
    $mail->Host = "smtp.gmail.com";

    // Enable SMTP authentication
    $mail->SMTPAuth = true;

    // Set SMTP encryption type (ssl/tls)
    $mail->SMTPSecure = "tls";

    // Port to connect SMTP
    $mail->Port = 587;

    // Set Gmail username
    // Use your own email
    $mail->Username = "rpquinones@up.edu.ph";

    // Set Gmail password
    // Turn on 2-factor auth on your/organization email
    // Go here https://myaccount.google.com/apppasswords
    // Copy-paste app password to this string
    $mail->Password = "sgreoylcwheqkoad";

    // Email subject
    $mail->Subject = "Charging Records and Remaining Time";

    // Set sender email
    $mail->setFrom('someone@up.edu.ph');

    // Enable HTML
    $mail->isHTML(true);

    // Email body
    $mail->Body = "Library Charging Hours Report";

    // Add recipient
    $mail->addAddress($adminEmail);

    // Add attachment
    $attachmentPath = 'reports.csv';
    $mail->addAttachment($attachmentPath);

    // Finally send email
    if ($mail->send()) {
        // Display alert for successful email sent
        echo '<script language="javascript">';
        echo 'alert("Charging Reports Sent to Admin Email")';
        echo '</script>';
        return true;
    } else {
        // Display alert for email not sent
        echo "<script>alert('Email Not Sent');</script>";
        return false;
    }


    // Closing SMTP connection
    $mail->smtpClose();
}

function executeOncePerDay($adminEmail)
{
    $lastExecutionFile = "last_execution.txt";

    // Check if the file exists
    if (!file_exists($lastExecutionFile)) {
        // Create the file and set the initial execution time to a past date
        file_put_contents($lastExecutionFile, "1970-01-01");
    }

    $lastExecutionTime = file_get_contents($lastExecutionFile);

    // Get the current date and time
    $currentDate = date("Y-m-d");
    $currentTime = date("H:i:s");

    // Check if the function has already been executed today
    if ($lastExecutionTime !== $currentDate) {
        // Execute the function
        sendEmailReport($adminEmail);

        // Update the last execution time
        file_put_contents($lastExecutionFile, $currentDate);
    }
}



?>