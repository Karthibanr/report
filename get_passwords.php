<?php
// Include database connection
include 'connection.php';
$conn->select_db('siet_lms');
// Fetch password data
$query = "SELECT 
                        sc.fullname AS courseName, 
                        q.name AS assessmentName, 
                        q.password AS Password,
                        sq.quitpassword AS QuitPassword
                    FROM sietlms_course sc
                    JOIN sietlms_quiz q ON sc.id = q.course
                    LEFT JOIN sietlms_quizaccess_seb_quizsettings sq ON sq.quizid = q.id
                    WHERE q.name like 'L_ - Test%'
                    ORDER BY q.name;"; 
$result = $conn->query($query);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    exit;
}

// Convert to JSON
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Output as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close connection
$conn->close();
?>