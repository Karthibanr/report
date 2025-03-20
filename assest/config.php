<?php
    $host = "localhost";  
    $user = "root";       
    $password = "password";       
    $database = "siet_lms"; 

    $conn = new mysqli($host, $user, $password, $database);
    // $conn = new mysqli($host, $user, $password);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
