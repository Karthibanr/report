<?php
$host = "localhost";  
$user = "root";       
$password = "password";       
$database = "report"; 

$conn = new mysqli($host, $user, $password, $database);

// Step 2: Query to fetch distinct cohort names after the first underscore and their associated ID (grouped)
$sql = "SELECT 
            distinct department dept
        FROM users";
$result = $conn->query($sql);

// Step 3: Generate the dropdown

echo '<select name="department" id="department">';

// Check if there are any rows returned
if ($result->num_rows > 0) {
    echo '<option value="All">All Departments</option>';
    // Loop through the results and create an option for each cohort
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['dept'] . '">' . $row['dept'] . '</option>';
    }
} else {
    echo '<option>No Department available</option>';
}

echo '</select>';



// Close the connection
$conn->close();
?>
