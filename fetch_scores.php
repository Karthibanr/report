<?php
include 'connection.php';

// Overall Scores
$sql = "SELECT u.user_id, u.name, u.institution, u.department, u.section, u.batch, u.course, u.graduation_year, s.score, c.course_name
        FROM users u
        JOIN scores s ON s.user_id = u.user_id
        JOIN courses c ON c.course_id = s.course_id";

// Execute query
$result = $conn->query($sql);

if (!$result) {
    die(json_encode([
        "status" => "error",
        "message" => "Query failed: " . $conn->error
    ]));
}

// Initialize data structure
$data = [
    "course_completion" => [
        "headers" => [],
        "rows" => []
    ]
];

// Process the results
$usersData = [];
$courseColumns = [];
$baseColumns = ["user_id", "name", "institution", "department", "section", "batch", "course", "graduation_year"];

// First pass: collect all unique users and courses
while ($row = $result->fetch_assoc()) {
    $userId = $row['user_id'];
    $courseName = $row['course_name'];
    
    // Add the course to our list of columns if it's not already there
    if (!in_array($courseName, $courseColumns)) {
        $courseColumns[] = $courseName;
    }
    
    // Initialize user data if not already done
    if (!isset($usersData[$userId])) {
        $userData = [];
        foreach ($baseColumns as $col) {
            $userData[$col] = $row[$col];
        }
        $usersData[$userId] = $userData;
    }
    
    // Add the score for this course
    $usersData[$userId][$courseName] = $row['score'];
}

// Build headers (base columns + course columns)
$data["course_completion"]["headers"] = array_merge($baseColumns, $courseColumns);

// Build rows in the requested format
foreach ($usersData as $userData) {
    $rowData = [];
    foreach ($data["course_completion"]["headers"] as $header) {
        $rowData[$header] = isset($userData[$header]) ? $userData[$header] : null;
    }
    $data["course_completion"]["rows"][] = $rowData;
}

// Close database connection
$conn->close();

// Set appropriate headers for JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow access from any origin, modify as needed
header('Access-Control-Allow-Methods: GET');

// Output the JSON data
echo json_encode([
    "status" => "success",
    "data" => $data
]);
?>