<?php
include 'connection.php';

$filters = [];

function fetchFilterOptions($conn, $query, $fieldName) {
    $options = [];
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options[] = $row[$fieldName];
        }
    }
    return $options;
}

$filters['batch'] = fetchFilterOptions($conn, "SELECT DISTINCT batch FROM users ORDER BY batch;", 'batch');
$filters['department'] = fetchFilterOptions($conn, "SELECT DISTINCT department FROM users ORDER BY department;", 'department');
$filters['graduation Year'] = fetchFilterOptions($conn, "SELECT DISTINCT graduation_year FROM users ORDER BY graduation_year;", 'graduation_year');
$filters['institution'] = fetchFilterOptions($conn, "SELECT DISTINCT institution FROM users ORDER BY institution;", 'institution');
$filters['course'] = fetchFilterOptions($conn, "SELECT DISTINCT programming FROM users ORDER BY programming;", 'programming');
$filters['section'] = fetchFilterOptions($conn, "SELECT DISTINCT section FROM users ORDER BY section;", 'section');

$conn->close();
?>
