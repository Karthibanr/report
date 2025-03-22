<?php

// Database credentials
$host = 'localhost'; // replace with your host
$dbname = 'siet_lms'; // replace with your database name
$username = 'root'; // replace with your database username
$password = 'password'; // replace with your database password
$reportDB='report';
try {
    // Create a PDO instance for database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo2 = new PDO("mysql:host=$host;dbname=$reportDB", $username, $password);
    $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Start transaction to ensure consistency
    $pdo->beginTransaction();
    
    $assmentName="select distinct name from sietlms_quiz where name like 'L_ - Test%';";
    $assStmt = $pdo->prepare($assmentName);
    $assStmt->execute();

    $assessments = $assStmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($assessments as $courseName) {
        $newPassword = str_pad(rand(0, pow(10, 6) - 1), 6, '0', STR_PAD_LEFT);
    
    $sql = "
    UPDATE 
        sietlms_quiz
    SET 
        password = :newPassword
    WHERE 
        name = :courseName
    ";
    
    // Prepare the statement
    $stmt = $pdo->prepare($sql);
    
    // Bind parameters to avoid SQL injection
    $stmt->bindParam(':newPassword', $newPassword);
    $stmt->bindParam(':courseName', $courseName);
    
    // Execute the query
    $stmt->execute();

    }
    $pdo->commit();

    $courseName=
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
            q.name like 'L_ - Test%'
        ORDER BY 
            q.name
        ";
        
        // Prepare the select query
        $stmtSelect = $pdo->prepare($sqlSelect);
        $stmtSelect->execute();
        
        // Fetch the results
        $quizzes = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
        
        // Display results in an HTML table
        
        foreach ($quizzes as $quiz) {
            $checkSql="select * from password_Details
            where course_name = :courseName
            and assessment_name= :assessmentName";
            $checkstmt = $pdo2->prepare($checkSql);
            $checkstmt->bindParam(':courseName', $quiz['courseName']);
            $checkstmt->bindParam(':assessmentName', $quiz['assessmentName']);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $finalSql="update password_Details set password= :password";
                $finalstmt=$pdo2->prepare($finalSql);
                $finalstmt->bindParam(':password',$quiz['Password']);
            }
            else{
                $finalSql="insert into password_Details values(:courseName,:assessmentName,:password,:quit);";
                $finalstmt=$pdo2->prepare($finalSql);
                $finalstmt->bindParam(':courseName', $quiz['courseName']);
                $finalstmt->bindParam(':assessmentName', $quiz['assessmentName']);
                $finalstmt->bindParam(':password',$quiz['Password']);
                $finalstmt->bindParam(':quit',$quiz['QuitPassword']);
            }
            $finalstmt->execute();
        }
        


    // Commit the transaction
    

} catch (PDOException $e) {
    // Rollback the transaction in case of an error
    $pdo->rollBack();
    // Handle connection errors or query issues
    echo "Error: " . $e->getMessage();
}

?>
