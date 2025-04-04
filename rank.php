<?php
include 'connection.php';

// SQL query to calculate ranks
$sql = "
    -- Overall Rank (Average Score Across All Courses)
    SELECT cs.username, 
        'Overall Rank' AS rank_type,
        RANK() OVER (
            PARTITION BY u.graduation_year
            ORDER BY AVG(cs.total) DESC
        ) AS rank_value
    FROM categoryscore cs
    JOIN users u ON u.username = cs.username
    GROUP BY cs.username, u.graduation_year

    UNION ALL

    -- Graduation Year Rank
    SELECT cs.username, 
        CONCAT(cs.course_name, ' - Rank_graduation_year') AS rank_type,
        RANK() OVER (
            PARTITION BY u.graduation_year, cs.course_name
            ORDER BY cs.total DESC
        ) AS rank_value
    FROM categoryscore cs
    JOIN users u ON u.username = cs.username
    
    UNION ALL
    
    -- Department Rank
    SELECT cs.username, 
        CONCAT(cs.course_name, ' - Rank_department') AS rank_type,
        RANK() OVER (
            PARTITION BY u.graduation_year, u.department, cs.course_name
            ORDER BY cs.total DESC
        ) AS rank_value
    FROM categoryscore cs
    JOIN users u ON u.username = cs.username
    
    UNION ALL
    
    -- Section Rank
    SELECT cs.username, 
        CONCAT(cs.course_name, ' - Rank_section') AS rank_type,
        RANK() OVER (
            PARTITION BY u.graduation_year, u.department, u.section, cs.course_name
            ORDER BY cs.total DESC
        ) AS rank_value
    FROM categoryscore cs
    JOIN users u ON u.username = cs.username
";

$result = $conn->query($sql);

// Check if results exist
if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Username</th><th>Rank Type</th><th>Rank</th></tr>";

    // Fetch and display results
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["rank_type"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["rank_value"]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No results found.";
}

// Close connection
$conn->close();
?>
