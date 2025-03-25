<?php
include 'connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', '0');


// Main function to orchestrate the process
function getScoresData()
{
    global $conn;

    // Initialize response data structure
    $data = [
        "practice_scores" => [
            "headers" => [],
            "rows" => []
        ],
        "test_scores" => [
            "headers" => [],
            "rows" => []
        ],
        "overall_scores" => [
            "headers" => [],
            "rows" => []
        ]
    ];

    $baseColumns = ["username", "institution", "department", "section", "batch", "programming", "graduation_year"];

    // Get the latest and previous dates from the database
    $latestDate = getLatestDate($conn);

    if (isset($_GET['previousDate'])) {
        $previousDateOption = (int) $_GET['previousDate'];

        // Calculate previous date based on option
        switch ($previousDateOption) {
            case 1:
                // 1 day before
                $previousDate = date('Y-m-d', strtotime($latestDate . ' -1 day'));
                break;
            case 2:
                // 3 days before
                $previousDate = date('Y-m-d', strtotime($latestDate . ' -3 days'));
                break;
            case 3:
                // 7 days before
                $previousDate = date('Y-m-d', strtotime($latestDate . ' -7 days'));
                break;
            case 4:
                // 1 month before
                $previousDate = date('Y-m-d', strtotime($latestDate . ' -1 month'));
                break;
            case 5:
                // 2 months before
                $previousDate = date('Y-m-d', strtotime($latestDate . ' -2 months'));
                break;
            case 6:
                // 3 months before
                $previousDate = date('Y-m-d', strtotime($latestDate . ' -3 months'));
                break;
            case 7:
                // 6 months before
                $previousDate = date('Y-m-d', strtotime($latestDate . ' -6 months'));
                break;
            case 8:
                // 1 year before
                $previousDate = date('Y-m-d', strtotime($latestDate . ' -1 year'));
                break;
            default:
                // Fallback to last available previous date in DB
                $previousDate = getPreviousDate($conn, $latestDate);
                break;
        }
    } else {
        // Default: previous date based on DB
        $previousDate = getPreviousDate($conn, $latestDate);
    }


    if (!$latestDate || !$previousDate) {
        return [
            "status" => "error",
            "message" => "Could not retrieve date information from the database"
        ];
    }

    // Get practice scores (non-test courses) for latest date
    $practiceSql = "SELECT u.*, ls.course_name, ls.total, ls.date
                    FROM users u
                    JOIN levelScore ls ON ls.username = u.username
                    WHERE ls.course_name NOT LIKE '%Test%' 
                    AND ls.date = '$latestDate'";

    // Execute query
    $practiceResult = $conn->query($practiceSql);

    if (!$practiceResult) {
        return [
            "status" => "error",
            "message" => "Practice scores query failed: " . $conn->error
        ];
    }

    // Get previous date's practice scores for diff calculation
    $previousPracticeSql = "SELECT ls.username, ls.course_name, ls.total 
                           FROM levelScore ls
                           WHERE course_name NOT LIKE '%Test%' 
                           AND ls.date = '$previousDate'";

    $previousPracticeResult = $conn->query($previousPracticeSql);

    if (!$previousPracticeResult) {
        return [
            "status" => "error",
            "message" => "Previous practice scores query failed: " . $conn->error
        ];
    }

    // Create lookup array for previous scores
    $previousPracticeScores = [];
    while ($row = $previousPracticeResult->fetch_assoc()) {
        $previousPracticeScores[$row['username'] . '_' . $row['course_name']] = $row['total'];
    }

    // Process practice scores with diff
    processResultsWithDiff($practiceResult, "practice_scores", $data, $baseColumns, $previousPracticeScores);

    // Get test scores (only test courses) for latest date
    $testSql = "SELECT u.*, ls.course_name, ls.total, ls.date
                FROM users u
                JOIN levelScore ls ON ls.username = u.username
                WHERE course_name LIKE '%Test%'
                AND ls.date = '$latestDate'";

    // Execute query
    $testResult = $conn->query($testSql);

    if (!$testResult) {
        return [
            "status" => "error",
            "message" => "Test scores query failed: " . $conn->error
        ];
    }

    // Get previous date's test scores for diff calculation
    $previousTestSql = "SELECT ls.username, ls.course_name, ls.total 
                        FROM levelScore ls
                        WHERE course_name LIKE '%Test%' 
                        AND ls.date = '$previousDate'";

    $previousTestResult = $conn->query($previousTestSql);

    if (!$previousTestResult) {
        return [
            "status" => "error",
            "message" => "Previous test scores query failed: " . $conn->error
        ];
    }

    // Create lookup array for previous scores
    $previousTestScores = [];
    while ($row = $previousTestResult->fetch_assoc()) {
        $previousTestScores[$row['username'] . '_' . $row['course_name']] = $row['total'];
    }

    // Process test scores with diff
    processResultsWithDiff($testResult, "test_scores", $data, $baseColumns, $previousTestScores);

    // Get overall scores for latest date
    $overallResult = getOverallScoresWithDate($conn, $latestDate);

    if (isset($overallResult["error"])) {
        return [
            "status" => "error",
            "message" => $overallResult["error"]
        ];
    }

    // Get previous date's overall scores for diff calculation
    $previousOverallScores = getPreviousOverallScores($conn, $previousDate);

    if (isset($previousOverallScores["error"])) {
        return [
            "status" => "error",
            "message" => $previousOverallScores["error"]
        ];
    }

    // Create lookup array for previous overall scores
    $previousOverallMap = [];
    foreach ($previousOverallScores as $row) {
        $previousOverallMap[$row['username'] . '_' . $row['course_name']] = $row['total'];
    }

    // Process overall scores with diff
    processArrayResultsWithDiff($overallResult, "overall_scores", $data, $baseColumns, $previousOverallMap);

    // Calculate rankings for overall scores
    calculateRankings($data);

    return [
        "status" => "success",
        "data" => $data,
        "dates" => [
            "latest" => $latestDate,
            "previous" => $previousDate
        ]
    ];
}

// Function to get the latest date from the database
function getLatestDate($conn)
{
    $sql = "SELECT MAX(date) as latest_date FROM levelScore";
    $result = $conn->query($sql);

    if (!$result) {
        return null;
    }

    $row = $result->fetch_assoc();
    return $row['latest_date'];
}

// Function to get the previous date from the database
function getPreviousDate($conn, $latestDate)
{
    $sql = "SELECT MAX(date) as previous_date FROM levelScore WHERE date < '$latestDate'";
    $result = $conn->query($sql);

    if (!$result) {
        return null;
    }

    $row = $result->fetch_assoc();
    return $row['previous_date'];
}

// Function to process query results and populate data with diff columns
function processResultsWithDiff($result, $dataKey, &$data, $baseColumns, $previousScores)
{
    // Process the results
    $usersData = [];
    $courseColumns = [];

    // First pass: collect all unique users and courses
    while ($row = $result->fetch_assoc()) {
        $userId = $row['username'];
        $courseName = $row['course_name'];
        $currentScore = $row['total'];

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
        $usersData[$userId][$courseName] = $currentScore;

        // Calculate diff with previous score
        $previousScore = isset($previousScores[$userId . '_' . $courseName]) ? $previousScores[$userId . '_' . $courseName] : 0;
        $diff = $currentScore - $previousScore;

        // Add the diff column
        $diffColumnName = $courseName . "_diff";
        $usersData[$userId][$diffColumnName] = $diff;
    }

    // Build headers (base columns + course columns + diff columns)
    $allColumns = $baseColumns;

    // Add both score and diff columns for each course
    foreach ($courseColumns as $course) {
        $allColumns[] = $course;
        $allColumns[] = $course . "_diff";
    }

    $data[$dataKey]["headers"] = $allColumns;

    // Build rows in the requested format
    foreach ($usersData as $userData) {
        $rowData = [];
        foreach ($data[$dataKey]["headers"] as $header) {
            $rowData[$header] = isset($userData[$header]) ? $userData[$header] : null;
        }
        $data[$dataKey]["rows"][] = $rowData;
    }
}

// Function to process array results with diff columns (for overall scores)
function processArrayResultsWithDiff($rows, $dataKey, &$data, $baseColumns, $previousScores)
{
    // Process the results
    $usersData = [];
    $courseColumns = [];

    // First pass: collect all unique users and courses
    foreach ($rows as $row) {
        $userId = $row['username'];
        $courseName = $row['course_name'];
        $currentScore = $row['total'];

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
        $usersData[$userId][$courseName] = $currentScore;

        // Calculate diff with previous score
        $previousScore = isset($previousScores[$userId . '_' . $courseName]) ? $previousScores[$userId . '_' . $courseName] : 0;
        $diff = $currentScore - $previousScore;

        // Add the diff column
        $diffColumnName = $courseName . "_diff";
        $usersData[$userId][$diffColumnName] = $diff;
    }

    // Build headers (base columns + course columns + diff columns)
    $allColumns = $baseColumns;

    // Add both score and diff columns for each course
    foreach ($courseColumns as $course) {
        $allColumns[] = $course;
        $allColumns[] = $course . "_diff";
    }

    $data[$dataKey]["headers"] = $allColumns;

    // Build rows in the requested format
    foreach ($usersData as $userData) {
        $rowData = [];
        foreach ($data[$dataKey]["headers"] as $header) {
            $rowData[$header] = isset($userData[$header]) ? $userData[$header] : null;
        }
        $data[$dataKey]["rows"][] = $rowData;
    }
}

// Function to get overall scores with date filter
function getOverallScoresWithDate($conn, $date)
{
    $overallSql = "SELECT u.*, cs.course_name, cs.total
                   FROM users u
                   JOIN categoryScore cs ON cs.username = u.username
                   WHERE cs.date = '$date'";

    $overallResult = $conn->query($overallSql);

    if (!$overallResult) {
        return ["error" => "Overall scores query failed: " . $conn->error];
    }

    // Process the result into an array
    $scores = [];
    while ($row = $overallResult->fetch_assoc()) {
        $scores[] = $row; // Fetch each row as an associative array
    }

    return $scores; // Return the processed data
}

// Function to get previous overall scores
function getPreviousOverallScores($conn, $previousDate)
{
    $sql = "SELECT cs.username, cs.course_name, cs.total
            FROM categoryScore cs
            WHERE cs.date = '$previousDate'";

    $result = $conn->query($sql);

    if (!$result) {
        return ["error" => "Previous overall scores query failed: " . $conn->error];
    }

    // Process the result into an array
    $scores = [];
    while ($row = $result->fetch_assoc()) {
        $scores[] = $row;
    }

    return $scores;
}

// Function to calculate rankings for overall scores
function calculateRankings(&$data)
{
    // Get course columns (excluding base columns)
    $baseColumnCount = 7; // Number of base columns
    $courseColumns = [];

    // Filter out only the actual course columns (not the diff columns)
    foreach (array_slice($data["overall_scores"]["headers"], $baseColumnCount) as $column) {
        if (strpos($column, '_diff') === false) {
            $courseColumns[] = $column;
        }
    }

    // For each course column, calculate rankings
    foreach ($courseColumns as $course) {
        // Extract scores for this course
        $scores = [];
        foreach ($data["overall_scores"]["rows"] as $index => $row) {
            if (isset($row[$course]) && is_numeric($row[$course])) {
                $scores[$index] = $row[$course];
            } else {
                $scores[$index] = 0; // Default score for missing or non-numeric values
            }
        }

        // Sort scores in descending order
        arsort($scores);

        // Assign ranks (handling ties)
        $rank = 1;
        $previousScore = null;
        $sameRankCount = 0;

        foreach ($scores as $index => $score) {
            if ($previousScore !== null && $score < $previousScore) {
                $rank += $sameRankCount;
                $sameRankCount = 1;
            } else if ($previousScore !== null && $score == $previousScore) {
                $sameRankCount++;
            } else {
                $sameRankCount = 1;
            }

            // Add rank to the data
            $rankColumn = $course . "_rank";
            $data["overall_scores"]["rows"][$index][$rankColumn] = $rank;

            $previousScore = $score;
        }

        // Add the rank column to headers
        $data["overall_scores"]["headers"][] = $rankColumn;
    }

    // Calculate overall rank across all courses
    $overallScores = [];
    foreach ($data["overall_scores"]["rows"] as $index => $row) {
        $totalScore = 0;
        $courseCount = 0;

        foreach ($courseColumns as $course) {
            if (isset($row[$course]) && is_numeric($row[$course])) {
                $totalScore += $row[$course];
                $courseCount++;
            }
        }

        // Calculate average score if user has taken any courses
        $overallScores[$index] = $courseCount > 0 ? $totalScore / $courseCount : 0;
    }

    // Sort overall scores in descending order
    arsort($overallScores);

    // Assign overall ranks
    $rank = 1;
    $previousScore = null;
    $sameRankCount = 0;

    foreach ($overallScores as $index => $score) {
        if ($previousScore !== null && $score < $previousScore) {
            $rank += $sameRankCount;
            $sameRankCount = 1;
        } else if ($previousScore !== null && $score == $previousScore) {
            $sameRankCount++;
        } else {
            $sameRankCount = 1;
        }

        // Add overall rank to the data
        $data["overall_scores"]["rows"][$index]["overall_rank"] = $rank;
        $data["overall_scores"]["rows"][$index]["overall_average"] = round($score, 2);

        $previousScore = $score;
    }

    // Add the overall rank column to headers
    $data["overall_scores"]["headers"][] = "overall_average";
    $data["overall_scores"]["headers"][] = "overall_rank";
}

// Main execution
$result = getScoresData();

// Set appropriate headers for JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Output the JSON data
echo json_encode($result);
?>