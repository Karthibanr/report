<?php
// Database connection details for both databases
$host = "localhost";  
$user = "root";       
$password = "password";       
$database = "siet_lms"; 

$conn = new mysqli($host, $user, $password, $database);
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', '0');
// Select the data from the siet_lms database (your provided query)
$query = "
    SELECT u.username,
        gi.itemname AS 'course_name',
        ROUND(gg.finalgrade,2) AS Grade
 
        FROM sietlms_course AS c
        JOIN sietlms_context AS ctx ON c.id = ctx.instanceid
        JOIN sietlms_role_assignments AS ra ON ra.contextid = ctx.id
        JOIN sietlms_user AS u ON u.id = ra.userid
        JOIN sietlms_grade_grades AS gg ON gg.userid = u.id
        JOIN sietlms_grade_items AS gi ON gi.id = gg.itemid
        JOIN sietlms_course_categories AS cc ON cc.id = c.category
 
        WHERE  gi.courseid = c.id  and c.fullname like '%placement%' and gi.itemtype != 'course'
        ORDER BY username;
    ";

// Perform the query on the siet_lms database
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Switch to the report database
    $conn->select_db('report');

    // Loop through each result and insert or update into the grades table
    while ($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $course_name = $row['course_name'];
        $grade = $row['Grade'];

        // Check if the record already exists in the grades table
        $checkQuery = "SELECT username, course_name, date FROM grades WHERE username = ? AND course_name = ? AND date = curdate()";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param('ss', $username, $course_name);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            // Insert the data if it does not exist
            $insertQuery = "
                INSERT INTO grades (username, course_name, grade)
                VALUES (?, ?, ?)
            ";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param('ssd', $username, $course_name, $grade);
            $insertStmt->execute();
            echo "Inserted: " . $username . " - " . $course_name . "<br>";
        } else {
            // Update the existing record if username, course_name, and date match
            $updateQuery = "
                UPDATE grades
                SET grade = ?
                WHERE username = ? AND course_name = ? AND date = ?
            ";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param('dsss', $grade, $username, $course_name, $date);
            $updateStmt->execute();
            echo "Updated: " . $username . " - " . $course_name . "<br>";
        }
    }
} else {
    echo "No data found for the specified query.";
}

// Close the connection
$conn->close();
?>
