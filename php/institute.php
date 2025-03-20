<?php
$host = "localhost";  
$user = "root";       
$password = "password";       
$database = "report"; 

$conn = new mysqli($host, $user, $password, $database);

// Step 2: Query to fetch distinct institutions
$sql = "SELECT DISTINCT institution FROM users";
$result = $conn->query($sql);

// Step 3: Generate the dropdown

echo '<select name="institution" id="institution">';

if ($result->num_rows > 0) {
    echo '<option value="All">All Institutions</option>';
    // Fetch the results and create an option for each distinct institution
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['institution'] . '">' . $row['institution'] . '</option>';
    }
} else {
    echo '<option>No institutions available</option>';
}

echo '</select>';


// Close the database connection
$conn->close();
?>
