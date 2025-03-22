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

// Get date information for both category and level scores
$dateQueryCategory = "SELECT MIN(date) as min_date, MAX(date) as max_date FROM categoryscore";
$dateResultCategory = $conn->query($dateQueryCategory);

if (!$dateResultCategory) {
    die(json_encode([
        "status" => "error",
        "message" => "Category date query failed: " . $conn->error
    ]));
}

$categoryDates = $dateResultCategory->fetch_assoc();
$category_min_date = $categoryDates['min_date'];
$category_max_date = $categoryDates['max_date'];

$dateQueryLevel = "SELECT MIN(date) as min_date, MAX(date) as max_date FROM levelscore";
$dateResultLevel = $conn->query($dateQueryLevel);

if (!$dateResultLevel) {
    die(json_encode([
        "status" => "error",
        "message" => "Level date query failed: " . $conn->error
    ]));
}

$levelDates = $dateResultLevel->fetch_assoc();
$level_min_date = $levelDates['min_date'];
$level_max_date = $levelDates['max_date'];

// Determine overall latest_date and previous_date
$latest_date = max($category_max_date, $level_max_date);
$previous_date = min($category_min_date, $level_min_date);

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
        $userData[$course . " - Diff"] = null;
    }
    
    // Initialize level columns with null values
    foreach ($levelColumns as $levelCourse) {
        $userData[$levelCourse] = null;
        $userData[$levelCourse . " - Diff"] = null;
    }
    
    $usersData[$username] = $userData;
}

// Get the latest category scores
$latestCategoryQuery = "SELECT username, course_name, total FROM categoryscore WHERE date = '$latest_date'";
$latestCategoryResult = $conn->query($latestCategoryQuery);

if (!$latestCategoryResult) {
    die(json_encode([
        "status" => "error",
        "message" => "Latest category scores query failed: " . $conn->error
    ]));
}

// Add latest category scores to user data
while ($row = $latestCategoryResult->fetch_assoc()) {
    $username = $row['username'];
    $course = $row['course_name'];
    $total = $row['total'];
    
    if (isset($usersData[$username])) {
        $usersData[$username][$course] = $total;
    }
}

// Get the previous category scores
$previousCategoryQuery = "SELECT username, course_name, total FROM categoryscore WHERE date = '$previous_date'";
$previousCategoryResult = $conn->query($previousCategoryQuery);

if (!$previousCategoryResult) {
    die(json_encode([
        "status" => "error",
        "message" => "Previous category scores query failed: " . $conn->error
    ]));
}

// Calculate and add category score differences
while ($row = $previousCategoryResult->fetch_assoc()) {
    $username = $row['username'];
    $course = $row['course_name'];
    $previousTotal = $row['total'];
    
    if (isset($usersData[$username])) {
        $latestTotal = $usersData[$username][$course];
        $diff = (!is_null($latestTotal) && !is_null($previousTotal)) ? $latestTotal - $previousTotal : "0";
        $usersData[$username][$course . " - Diff"] = $diff;
    }
}

// Get the latest level scores
$latestLevelQuery = "SELECT username, course_name, total FROM levelscore WHERE date = '$latest_date'";
$latestLevelResult = $conn->query($latestLevelQuery);

if (!$latestLevelResult) {
    die(json_encode([
        "status" => "error",
        "message" => "Latest level scores query failed: " . $conn->error
    ]));
}

// Add latest level scores to user data
while ($row = $latestLevelResult->fetch_assoc()) {
    $username = $row['username'];
    $levelCourse = $row['course_name'];
    $total = $row['total'];
    
    if (isset($usersData[$username])) {
        $usersData[$username][$levelCourse] = $total;
    }
}

// Get the previous level scores
$previousLevelQuery = "SELECT username, course_name, total FROM levelscore WHERE date = '$previous_date'";
$previousLevelResult = $conn->query($previousLevelQuery);

if (!$previousLevelResult) {
    die(json_encode([
        "status" => "error",
        "message" => "Previous level scores query failed: " . $conn->error
    ]));
}

// Calculate and add level score differences
while ($row = $previousLevelResult->fetch_assoc()) {
    $username = $row['username'];
    $levelCourse = $row['course_name'];
    $previousTotal = $row['total'];
    
    if (isset($usersData[$username])) {
        $latestTotal = $usersData[$username][$levelCourse];
        $diff = (!is_null($latestTotal) && !is_null($previousTotal)) ? $latestTotal - $previousTotal : "0";
        $usersData[$username][$levelCourse . " - Diff"] = $diff;
    }
}

// Build headers
$headers = $baseColumns;

// Add category columns with their diff columns
foreach ($categoryColumns as $course) {
    $headers[] = $course;
    $headers[] = $course . " - Diff";
}

// Add level columns with their diff columns
foreach ($levelColumns as $levelCourse) {
    $headers[] = $levelCourse;
    $headers[] = $levelCourse . " - Diff";
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

// Add date information to the response
$data["date_info"] = [
    "latest_date" => $latest_date,
    "previous_date" => $previous_date
];

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