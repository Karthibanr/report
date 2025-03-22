<?php

// Database credentials
$host = 'localhost'; // replace with your host
$dbname = 'siet_lms'; // replace with your database name
$username = 'root'; // replace with your database username
$password = 'password'; // replace with your database password

// New password to set
$newPassword = 'newpassword';  // Replace with the new quiz password

// Course name to filter
$courseName = 'L1 - Test - PS - 1';  // Replace with the course name

try {
    // Create a PDO instance for database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Start transaction to ensure consistency
    $pdo->beginTransaction();
    
    // Prepare the SQL query to update the password (excluding quitpassword)
    $sql = "
    UPDATE 
        sietlms_quiz q
    JOIN 
        sietlms_course sc ON sc.id = q.course
    SET 
        q.password = :newPassword
    WHERE 
        q.name = :courseName
    ";
    
    // Prepare the statement
    $stmt = $pdo->prepare($sql);
    
    // Bind parameters to avoid SQL injection
    $stmt->bindParam(':newPassword', $newPassword);
    $stmt->bindParam(':courseName', $courseName);
    
    // Execute the query
    $stmt->execute();
    
    // Check if any rows were updated
    if ($stmt->rowCount() > 0) {
        // If the update was successful, fetch the updated data
        $sqlSelect = "
        SELECT 
            sc.fullname AS courseName, 
            q.name AS assessmentName, 
            q.password AS Password,
            sq.quitpassword AS QuitPassword
        FROM 
            sietlms_course sc
        JOIN 
            sietlms_quiz q ON sc.id = q.course
        LEFT JOIN 
            sietlms_quizaccess_seb_quizsettings sq ON sq.quizid = q.id
        WHERE 
            q.name = :courseName
        ORDER BY 
            q.name
        ";
        
        // Prepare the select query
        $stmtSelect = $pdo->prepare($sqlSelect);
        $stmtSelect->bindParam(':courseName', $courseName);
        $stmtSelect->execute();
        
        // Fetch the results
        $quizzes = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
        
        // Display results in an HTML table
        echo "<table border='1'>";
        echo "<tr><th>Course Name</th><th>Assessment Name</th><th>Password</th><th>Quit Password</th></tr>";
        
        foreach ($quizzes as $quiz) {
            echo "<tr>
                    <td>" . htmlspecialchars($quiz['courseName']) . "</td>
                    <td>" . htmlspecialchars($quiz['assessmentName']) . "</td>
                    <td>" . htmlspecialchars($quiz['Password']) . "</td>
                    <td>" . htmlspecialchars($quiz['QuitPassword']) . "</td>
                  </tr>";
        }
        
        echo "</table>";
    } else {
        echo "No records were updated.";
    }

    // Commit the transaction
    $pdo->commit();

} catch (PDOException $e) {
    // Rollback the transaction in case of an error
    $pdo->rollBack();
    // Handle connection errors or query issues
    echo "Error: " . $e->getMessage();
}

?>
