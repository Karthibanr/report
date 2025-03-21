<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('max_execution_time', '0');

    $host = "localhost";  
    $user = "root";       
    $password = "password";       
    $database = "siet_lms"; 

    $conn = new mysqli($host, $user, $password, $database);


$conn->select_db('siet_lms');
// Select the data from the siet_lms database
$query = "
    SELECT
        u.username,
        u.firstname,
        u.lastname,
        u.institution,
        u.department,
        ucf1.data AS section,
        ucf2.data AS batch,
        ucf3.data AS programming,
        ucf4.data AS graduation_year
    FROM
        sietlms_user u
    LEFT JOIN
        sietlms_user_info_data ucf1 ON ucf1.userid = u.id AND ucf1.fieldid = (SELECT id FROM sietlms_user_info_field WHERE shortname = 'section')
    LEFT JOIN
        sietlms_user_info_data ucf2 ON ucf2.userid = u.id AND ucf2.fieldid = (SELECT id FROM sietlms_user_info_field WHERE shortname = 'batch')
    LEFT JOIN
        sietlms_user_info_data ucf3 ON ucf3.userid = u.id AND ucf3.fieldid = (SELECT id FROM sietlms_user_info_field WHERE shortname = 'programming')
    LEFT JOIN
        sietlms_user_info_data ucf4 ON ucf4.userid = u.id AND ucf4.fieldid = (SELECT id FROM sietlms_user_info_field WHERE shortname = 'graduation_year')
    where username in('ads_230121','cys_230066','anjuts014@gmail.com');
";

echo $query;

// Perform the query on the siet_lms database
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Switch to the report database
    $conn->select_db('report');

    // Loop through each record and insert or update the user data in the report database
    while ($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $institution = $row['institution'];
        $department = $row['department'];
        $section = $row['section'];
        $batch = $row['batch'];
        $programming = $row['programming'];
        $graduation_year = $row['graduation_year'];

        // Check if the username already exists in the report database
        $checkQuery = "SELECT username FROM users WHERE username = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            // Insert the data if username does not exist
            $insertQuery = "
                INSERT INTO users (username, firstname, lastname, institution, department, section, batch, programming, graduation_year)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param('sssssssss', $username, $firstname, $lastname, $institution, $department, $section, $batch, $programming, $graduation_year);
            $insertStmt->execute();
            // echo "Inserted: " . $username . "<br>";
        } else {
            // Update the data if username already exists
            $updateQuery = "
                UPDATE users
                SET firstname = ?, lastname = ?, institution = ?, department = ?, section = ?, batch = ?, programming = ?, graduation_year = ?
                WHERE username = ?
            ";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param('sssssssss', $firstname, $lastname, $institution, $department, $section, $batch, $programming, $graduation_year, $username);
            $updateStmt->execute();
            echo "Updated: " . $username . "<br>";
        }
    }
} else {
    echo "No data found in siet_lms.sietlms_user.";
}

// Close the connection
$conn->close();
?>
