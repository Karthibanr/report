<?php
include 'connection.php';

// Initialize data structure with your required format
$data = [
    "overall_performance" => [
        "headers" => [],
        "rows" => []
    ]
];

// Base user columns
$baseColumns = ["username", "institution", "department", "section", "batch", "programming", "graduation_year"];

// First get all users
$usersQuery = "SELECT * FROM users";
$usersResult = $conn->query($usersQuery);

if (!$usersResult) {
    die(json_encode([
        "status" => "error",
        "message" => "Users query failed: " . $conn->error
    ]));
}

// Get all category courses
$categoryCoursesQuery = "SELECT DISTINCT course_name FROM categoryscore";
$categoryCoursesResult = $conn->query($categoryCoursesQuery);

if (!$categoryCoursesResult) {
    die(json_encode([
        "status" => "error",
        "message" => "Category courses query failed: " . $conn->error
    ]));
}

$categoryColumns = [];
while ($row = $categoryCoursesResult->fetch_assoc()) {
    $categoryColumns[] = $row['course_name'];
}

// Get all level courses
$levelCoursesQuery = "SELECT DISTINCT course_name FROM levelscore";
$levelCoursesResult = $conn->query($levelCoursesQuery);

if (!$levelCoursesResult) {
    die(json_encode([
        "status" => "error",
        "message" => "Level courses query failed: " . $conn->error
    ]));
}

$levelColumns = [];
while ($row = $levelCoursesResult->fetch_assoc()) {
    $levelColumns[] = $row['course_name'];
}

// Initialize users data structure
$usersData = [];
while ($row = $usersResult->fetch_assoc()) {
    $username = $row['username'];
    $userData = [];
    
    // Add base user information
    foreach ($baseColumns as $col) {
        // Only add columns that actually exist in the users table
        if (isset($row[$col])) {
            $userData[$col] = $row[$col];
        }
    }
    
    // Initialize course data with null values
    foreach ($categoryColumns as $course) {
        $userData[$course] = null;
    }
    
    // Initialize level columns with null values
    foreach ($levelColumns as $levelCourse) {
        $userData[$levelCourse] = null;
    }
    
    $usersData[$username] = $userData;
}

// Get category scores
$categoryQuery = "SELECT username, course_name, total FROM categoryscore";
$categoryResult = $conn->query($categoryQuery);

if (!$categoryResult) {
    die(json_encode([
        "status" => "error",
        "message" => "Category scores query failed: " . $conn->error
    ]));
}

// Add category scores to user data
while ($row = $categoryResult->fetch_assoc()) {
    $username = $row['username'];
    $course = $row['course_name'];
    $total = $row['total'];
    
    if (isset($usersData[$username])) {
        $usersData[$username][$course] = $total;
    }
}

// Get level scores
$levelQuery = "SELECT username, course_name, total FROM levelscore";
$levelResult = $conn->query($levelQuery);

if (!$levelResult) {
    die(json_encode([
        "status" => "error",
        "message" => "Level scores query failed: " . $conn->error
    ]));
}

// Add level scores to user data
while ($row = $levelResult->fetch_assoc()) {
    $username = $row['username'];
    $levelCourse = $row['course_name'];
    $total = $row['total'];
    
    if (isset($usersData[$username])) {
        $usersData[$username][$levelCourse] = $total;
    }
}

// Build headers
$headers = $baseColumns;

// Add category columns
foreach ($categoryColumns as $course) {
    $headers[] = $course;
}

// Add level columns
foreach ($levelColumns as $levelCourse) {
    $headers[] = $levelCourse;
}

$data["overall_performance"]["headers"] = $headers;

// Build rows
foreach ($usersData as $userData) {
    $row = [];
    foreach ($headers as $header) {
        $row[$header] = isset($userData[$header]) ? $userData[$header] : null;
    }
    $data["overall_performance"]["rows"][] = $row;
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