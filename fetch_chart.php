<?php
include 'connection.php';

$data = [
    'course_total' => [],
];

$courses = [
    "L1 - Practice - PS", "L2 - Practice - PS", "L3 - Practice - PS", "L4 - Practice - PS", "L5 - Practice - PS", "L6 - Practice - PS", "L7 - Practice - PS", "L8 - Practice - PS",
    "L1 - Practice - DS", "L2 - Practice - DS",
    "L1 - Practice - DB", "L2 - Practice - DB", "L3 - Practice - DB", "L4 - Practice - DB",
    "L1 - Practice - OOP", "L2 - Practice - OOP",
    "L1 - Test - PS", "L2 - Test - PS", "L3 - Test - PS", "L4 - Test - PS", "L5 - Test - PS", "L6 - Test - PS", "L7 - Test - PS", "L8 - Test - PS",
    "L1 - Test - DS", "L2 - Test - DS",
    "L1 - Test - DB", "L2 - Test - DB", "L3 - Test - DB", "L4 - Test - DB",
    "L1 - Test - OOP", "L2 - Test - OOP"
];

foreach ($courses as $course) {
    $query = "SELECT COUNT(DISTINCT course_name) * 100 AS total_score FROM grades WHERE course_name LIKE '$course%'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $score = $row['total_score'];

    $data['course_total'][] = [
        'course_name' => $course,
        'total_score' => $score
    ];
}

header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
