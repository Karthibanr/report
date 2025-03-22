<?php

// Database credentials
$host = 'localhost'; 
$dbname = 'siet_lms'; 
$username = 'root'; 
$password = 'password'; 
$reportDB='report';
        $conn = new mysqli($host, $username, $password, $dbname);
        $connReport= new mysqli($host, $username, $password, $reportDB);
        $courseSql="SELECT 
                        sc.fullname AS courseName, 
                        q.name AS assessmentName, 
                        q.password AS Password,
                        sq.quitpassword AS QuitPassword
                    FROM sietlms_course sc
                    JOIN sietlms_quiz q ON sc.id = q.course
                    LEFT JOIN sietlms_quizaccess_seb_quizsettings sq ON sq.quizid = q.id
                    WHERE q.name like 'L_ - Test%'
                    ORDER BY q.name;";
        // echo $courseSql;
        $result = $conn->query($courseSql);
        // echo ($result->num_rows);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $newPassword = str_pad(rand(0, pow(10, 6) - 1), 6, '0', STR_PAD_LEFT);

                $originalUpdateSql="UPDATE sietlms_quiz
                                        SET password = ".$newPassword."
                                        WHERE name = '".$row['assessmentName']."'";

                $originalUpdateResult=$conn->query($originalUpdateSql);
                
                $checkSql="select * from password_Details
                            where course_name='".$row['courseName']."' and assessment_name='".$row['assessmentName']."';";
                // echo $checkSql;
                $checkResult=$connReport->query($checkSql);
                if($checkResult->num_rows>0){
                    $updateSQL="update password_Details set password=".$newPassword." 
                            where course_name='".$row['courseName']."' 
                            and assessment_name='".$row['assessmentName']."';";
                    // echo $updateSQL;
                    $updateResult=$connReport->query($updateSQL);
                }
                else{
                    $insertSql="insert into password_Details values('".$row['courseName']."','".$row['assessmentName']."',".$newPassword.",".$row['QuitPassword'].");";
                    $insertResult=$connReport->query($insertSql);
                }
            }
        }
        else{
            echo "FALSE";
        }
        $conn->close();
        $connReport->close();
?>
