<?php
$host = "localhost";  
$user = "root";       
$password = "password";       
$database = "report"; 

$conn = new mysqli($host, $user, $password, $database);

// Step 2: Query to fetch all cohorts with the first 4 characters of their name
$sql = "SELECT distinct batch
FROM users
order by batch;";
$result = $conn->query($sql);

// Step 3: Create a unique array to store short names and avoid duplicates
$short_names =[];


echo '<select name="batch" id="batch">';

if ($result->num_rows > 0) {
    echo '<option value="All">All Batches</option>';
    // Loop through the results
    while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['batch'] . '">' . $row['batch'] . '</option>';
    }
} else {
    echo '<option>No Batch available</option>';
}

echo '</select>';


// Close the connection
$conn->close();
?>
