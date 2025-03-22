<?php
$host = "127.0.0.1";  
$user = "root";       
$password = "password";       
$database = "report"; 

// Create a single database connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>