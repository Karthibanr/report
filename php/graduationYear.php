<?php
$host = "localhost";  
$user = "root";       
$password = "password";       
$database = "report"; 

$conn = new mysqli($host, $user, $password, $database);

// Step 2: Query to fetch all cohorts with the first 4 characters of their name
$sql = "SELECT distinct graduation_year
FROM users
order by graduation_year;";
$result = $conn->query($sql);

// Step 3: Create a unique array to store short names and avoid duplicates
$short_names =[];


echo '<select name="graduation_year" id="graduation_year">';

if ($result->num_rows > 0) {
    echo '<option value="All">All graduation_year</option>';
    // Loop through the results
    while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['graduation_year'] . '">' . $row['graduation_year'] . '</option>';
    }
} else {
    echo '<option>No Graduation Year available</option>';
}

echo '</select>';


// Close the connection
$conn->close();
?>
