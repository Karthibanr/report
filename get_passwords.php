<?php
// Include database connection
include 'connection.php';

// Fetch password data
$query = "SELECT * FROM password_Details"; 
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