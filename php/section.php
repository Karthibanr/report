<?php
$host = "localhost";  
$user = "root";       
$password = "password";       
$database = "report"; 

$conn = new mysqli($host, $user, $password, $database);

// Step 2: Query to fetch all cohorts with the first 4 characters of their name
$sql = "SELECT distinct section
FROM users
order by batch;";
$result = $conn->query($sql);

// Step 3: Create a unique array to store short names and avoid duplicates
$short_names =[];


echo '<select name="section" id="section">';

if ($result->num_rows > 0) {
    echo '<option value="All">All Sections</option>';
    // Loop through the results
    while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['section'] . '">' . $row['section'] . '</option>';
    }
} else {
    echo '<option>No Section available</option>';
}

echo '</select>';


// Close the connection
$conn->close();
?>
