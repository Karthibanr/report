<?php
$host = 'localhost';
$dbname = 'siet_lms';
$username = 'root';
$password = 'password';
try {
   $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "
    UPDATE 
        sietlms_quiz 
    SET 
        timeopen = UNIX_TIMESTAMP(DATE_ADD(NOW(), INTERVAL 15 MINUTE)),
        timeclose = UNIX_TIMESTAMP(DATE_ADD(DATE_ADD(NOW(), INTERVAL 15 MINUTE), INTERVAL 90 MINUTE))
    WHERE 
        name LIKE 'L_ - Test - %';
    ";
    $stmt = $pdo->prepare($sql);

    // Execute the query
    $stmt->execute();
} catch (PDOException $e) {
    // Handle connection errors or query issues
    echo "Error: " . $e->getMessage();
}
?>
