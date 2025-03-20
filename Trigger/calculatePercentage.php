<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('max_execution_time', '0');

    $host = "localhost";  
    $user = "root";       
    $password = "password";       
    $database = "report"; 

    $conn = new mysqli($host, $user, $password, $database);

    $batch = $_POST['batch'];
    $department = $_POST['department'];
    $institution = $_POST['institution'];
    $graduation_year = $_POST['graduation_year'];
    $section = $_POST['section'];
    $programming = $_POST['programming'];

    $whereClause = '';
    
    if ($batch != "All") {
        if ($whereClause == '') $whereClause = " WHERE batch = '".$batch."'";
        else $whereClause .= " AND batch = '".$batch."'";
    }

    if ($department != "All") {
        if ($whereClause == '') $whereClause = " WHERE department = '".$department."'";
        else $whereClause .= " AND department = '".$department."'";
    }

    if ($institution != "All") {
        if ($whereClause == '') $whereClause = " WHERE institution = '".$institution."'";
        else $whereClause .= " AND institution = '".$institution."'";
    }

    if ($graduation_year != "All") {
        if ($whereClause == '') $whereClause = " WHERE graduation_year = '".$graduation_year."'";
        else $whereClause .= " AND graduation_year = '".$graduation_year."'";
    }

    if ($section != "All") {
        if ($whereClause == '') $whereClause = " WHERE section = '".$section."'";
        else $whereClause .= " AND section = '".$section."'";
    }

    if ($programming != "All") {
        if ($whereClause == '') $whereClause = " WHERE programming = '".$programming."'";
        else $whereClause .= " AND programming = '".$programming."'";
    }

    $studentListSql = "SELECT DISTINCT username, CONCAT(firstname, ' ', lastname) AS fullname, institution,
                        department, section, graduation_year, batch, programming 
                        FROM users";
    $studentListSql .= $whereClause;
    
    $result = $conn->query($studentListSql);

    $ppscourses = ["L1 - Practice - PS", "L2 - Practice - PS", "L3 - Practice - PS", "L4 - Practice - PS", "L5 - Practice - PS", "L6 - Practice - PS", "L7 - Practice - PS", "L8 - Practice - PS"];
    $pdscourses = ["L1 - Practice - DS", "L2 - Practice - DS", "L3 - Practice - DS", "L4 - Practice - DS", "L5 - Practice - DS", "L6 - Practice - DS", "L7 - Practice - DS", "L8 - Practice - DS"];
    $pdbcourses = ["L1 - Practice - DB", "L2 - Practice - DB", "L3 - Practice - DB", "L4 - Practice - DB", "L5 - Practice - DB", "L6 - Practice - DB", "L7 - Practice - DB", "L8 - Practice - DB"];
    $poopcourses = ["L1 - Practice - OOP", "L2 - Practice - OOP", "L3 - Practice - OOP", "L4 - Practice - OOP", "L5 - Practice - OOP", "L6 - Practice - OOP", "L7 - Practice - OOP", "L8 - Practice - OOP"];
    $tpscourses = ["L1 - Test - PS", "L2 - Test - PS", "L3 - Test - PS", "L4 - Test - PS", "L5 - Test - PS", "L6 - Test - PS", "L7 - Test - PS", "L8 - Test - PS"];
    $tdscourses = ["L1 - Test - DS", "L2 - Test - DS", "L3 - Test - DS", "L4 - Test - DS", "L5 - Test - DS", "L6 - Test - DS", "L7 - Test - DS", "L8 - Test - DS"];
    $tdbcourses = ["L1 - Test - DB", "L2 - Test - DB", "L3 - Test - DB", "L4 - Test - DB", "L5 - Test - DB", "L6 - Test - DB", "L7 - Test - DB", "L8 - Test - DB"];
    $toopcourses = ["L1 - Test - OOP", "L2 - Test - OOP", "L3 - Test - OOP", "L4 - Test - OOP", "L5 - Test - OOP", "L6 - Test - OOP", "L7 - Test - OOP", "L8 - Test - OOP"];
    
    
    $output = '<!DOCTYPE html>
<html lang="en">
<head>
    <style>
    table, td, th {
    border: 1px solid black;
    }

    table {
    border-collapse: collapse;
    width: 100%;
    }

    td {
    text-align: center;
    }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Report</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#studentTable").DataTable();
        });
    </script>
</head>
<body>

<table id="studentTable" class="display" border="1" align="center">
    <thead>
    <tr>
        <td colspan=75>Placement Course Report</td>
    </tr>
    <tr>
        <td rowspan=3>Username</td>
        <td colspan=36> Practice - Report</td>
        <td colspan=36> Test - Report </td>
        <td rowspan=3>Over-all Total</td>
    </tr>
    <tr>
        <td colspan=9> Problem Solving </td>
        <td colspan=9> DataStructures </td>
        <td colspan=9> DataBase Management Systems </td>
        <td colspan=9> Object Oriented Programming </td>
        
        <td colspan=9> Problem Solving </td>
        <td colspan=9> DataStructures </td>
        <td colspan=9> DataBase Management Systems </td>
        <td colspan=9> Object Oriented Programming </td>
    </tr>
        <tr>
            <th>L1</th><th>L2</th><th>L3</th><th>L4</th><th>L5</th><th>L6</th><th>L7</th><th>L8</th><th>PPS - Total</th>
            <th>L1</th><th>L2</th><th>L3</th><th>L4</th><th>L5</th><th>L6</th><th>L7</th><th>L8</th><th>PDS - Total</th>
            <th>L1</th><th>L2</th><th>L3</th><th>L4</th><th>L5</th><th>L6</th><th>L7</th><th>L8</th><th>PDB - Total</th>
            <th>L1</th><th>L2</th><th>L3</th><th>L4</th><th>L5</th><th>L6</th><th>L7</th><th>L8</th><th>POOP - Total</th>
            <th>L1</th><th>L2</th><th>L3</th><th>L4</th><th>L5</th><th>L6</th><th>L7</th><th>L8</th><th>TPS - Total</th>
            <th>L1</th><th>L2</th><th>L3</th><th>L4</th><th>L5</th><th>L6</th><th>L7</th><th>L8</th><th>TDS - Total</th>
            <th>L1</th><th>L2</th><th>L3</th><th>L4</th><th>L5</th><th>L6</th><th>L7</th><th>L8</th><th>TDB - Total</th>
            <th>L1</th><th>L2</th><th>L3</th><th>L4</th><th>L5</th><th>L6</th><th>L7</th><th>L8</th><th>TOOP - Total</th>
        </tr>
    </thead>
    <tbody>';

$categoryTotal=$overAllTotal=0;
$tempCourse='';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= '<tr><td>' . $row["username"] . '</td>';

        // Practice Problem Solving couse level 1 to 8
        foreach ($ppscourses as $course) {
            $completionQuery = "SELECT username, ROUND(SUM(grade) / (COUNT(course_name) * 100), 2) * 100 AS Percentage  
                                FROM grades 
                                WHERE course_name LIKE '%".$course."%' 
                                AND username = '".$row["username"]."' 
                                AND date = CURDATE() 
                                GROUP BY username;";
            $completionResult = $conn->query($completionQuery);
            if ($completionResult->num_rows > 0) {
                while ($completionRow = $completionResult->fetch_assoc()) {
                    if ($completionRow["Percentage"] == NULL){
                        $completionRow['Percentage']=0;
                        $output .= '<td>0</td>';
                    }
                        
                    else {
                        $output .= '<td>' . $completionRow["Percentage"] . '</td>';
                        $categoryTotal+=$completionRow["Percentage"];
                        $tempCourse=$course;
                    }
                    $levelInsertSql="insert into levelScore(username,course_name,total)
                    values('".$row['username']."','".$course."','".$completionRow['Percentage']."');";
                    $levelInsertResult = $conn->query($levelInsertSql);
                }
            } else {
                $output .= '<td>0</td>';
            }
        }
        $output .= '<td>'.$categoryTotal.'</td>';

        $parts = explode(' - ', $tempCourse);
        $insCourse = $parts[1] . ' - ' . $parts[2];

        $cateInsertSql="insert into categoryScore(username,course_name,total)
            values('".$row['username']."','".$insCourse."','".$categoryTotal."');";
        $cateInsertResult = $conn->query($cateInsertSql);

        $overAllTotal+=$categoryTotal;

        $categoryTotal=0;

        // Practice  DS Course
        foreach ($pdscourses as $course) {
            $completionQuery = "SELECT username, ROUND(SUM(grade) / (COUNT(course_name) * 100), 2) * 100 AS Percentage  
                                FROM grades 
                                WHERE course_name LIKE '%".$course."%' 
                                AND username = '".$row["username"]."' 
                                AND date = CURDATE() 
                                GROUP BY username;";
            $completionResult = $conn->query($completionQuery);
            if ($completionResult->num_rows > 0) {
                while ($completionRow = $completionResult->fetch_assoc()) {
                    if ($completionRow["Percentage"] == NULL){
                        $completionRow['Percentage']=0;
                        $output .= '<td>0</td>';
                    }
                        
                    else {
                        $output .= '<td>' . $completionRow["Percentage"] . '</td>';
                        $categoryTotal+=$completionRow["Percentage"];
                        $tempCourse=$course;
                    }
                    $levelInsertSql="insert into levelScore(username,course_name,total)
                    values('".$row['username']."','".$course."','".$completionRow['Percentage']."');";
                    $levelInsertResult = $conn->query($levelInsertSql);
                }
            } else {
                $output .= '<td>0</td>';
            }
        }
        $output .= '<td>'.$categoryTotal.'</td>';

        $parts = explode(' - ', $tempCourse);
        $insCourse = $parts[1] . ' - ' . $parts[2];

        $cateInsertSql="insert into categoryScore(username,course_name,total)
            values('".$row['username']."','".$insCourse."','".$categoryTotal."');";
        $cateInsertResult = $conn->query($cateInsertSql);

        $overAllTotal+=$categoryTotal;
        $categoryTotal=0;

        // Practice  DB Course
foreach ($pdbcourses as $course) {
            $completionQuery = "SELECT username, ROUND(SUM(grade) / (COUNT(course_name) * 100), 2) * 100 AS Percentage  
                                FROM grades 
                                WHERE course_name LIKE '%".$course."%' 
                                AND username = '".$row["username"]."' 
                                AND date = CURDATE() 
                                GROUP BY username;";
            $completionResult = $conn->query($completionQuery);
            if ($completionResult->num_rows > 0) {
                while ($completionRow = $completionResult->fetch_assoc()) {
                    if ($completionRow["Percentage"] == NULL){
                        $completionRow['Percentage']=0;
                        $output .= '<td>0</td>';
                    }
                        
                    else {
                        $output .= '<td>' . $completionRow["Percentage"] . '</td>';
                        $categoryTotal+=$completionRow["Percentage"];
                        $tempCourse=$course;
                    }
                    $levelInsertSql="insert into levelScore(username,course_name,total)
                    values('".$row['username']."','".$course."','".$completionRow['Percentage']."');";
                    $levelInsertResult = $conn->query($levelInsertSql);
                }
            } else {
                $output .= '<td>0</td>';
            }
        }
        $output .= '<td>'.$categoryTotal.'</td>';

        $parts = explode(' - ', $tempCourse);
        $insCourse = $parts[1] . ' - ' . $parts[2];

        $cateInsertSql="insert into categoryScore(username,course_name,total)
            values('".$row['username']."','".$insCourse."','".$categoryTotal."');";
        $cateInsertResult = $conn->query($cateInsertSql);

        $overAllTotal+=$categoryTotal;
        $categoryTotal=0;

        // Practice  OOPS Course
foreach ($poopcourses as $course) {
            $completionQuery = "SELECT username, ROUND(SUM(grade) / (COUNT(course_name) * 100), 2) * 100 AS Percentage  
                                FROM grades 
                                WHERE course_name LIKE '%".$course."%' 
                                AND username = '".$row["username"]."' 
                                AND date = CURDATE() 
                                GROUP BY username;";
            $completionResult = $conn->query($completionQuery);
            if ($completionResult->num_rows > 0) {
                while ($completionRow = $completionResult->fetch_assoc()) {
                    if ($completionRow["Percentage"] == NULL){
                        $completionRow['Percentage']=0;
                        $output .= '<td>0</td>';
                    }
                        
                    else {
                        $output .= '<td>' . $completionRow["Percentage"] . '</td>';
                        $categoryTotal+=$completionRow["Percentage"];
                        $tempCourse=$course;
                    }
                    $levelInsertSql="insert into levelScore(username,course_name,total)
                    values('".$row['username']."','".$course."','".$completionRow['Percentage']."');";
                    $levelInsertResult = $conn->query($levelInsertSql);
                }
            } else {
                $output .= '<td>0</td>';
            }
        }
        $output .= '<td>'.$categoryTotal.'</td>';

        $parts = explode(' - ', $tempCourse);
        $insCourse = $parts[1] . ' - ' . $parts[2];

        $cateInsertSql="insert into categoryScore(username,course_name,total)
            values('".$row['username']."','".$insCourse."','".$categoryTotal."');";
        $cateInsertResult = $conn->query($cateInsertSql);

        $overAllTotal+=$categoryTotal;
        $categoryTotal=0;

        // Test PS Course
foreach ($tpscourses as $course) {
            $completionQuery = "SELECT username, ROUND(SUM(grade) / (COUNT(course_name) * 100), 2) * 100 AS Percentage  
                                FROM grades 
                                WHERE course_name LIKE '%".$course."%' 
                                AND username = '".$row["username"]."' 
                                AND date = CURDATE() 
                                GROUP BY username;";
            $completionResult = $conn->query($completionQuery);
            if ($completionResult->num_rows > 0) {
                while ($completionRow = $completionResult->fetch_assoc()) {
                    if ($completionRow["Percentage"] == NULL){
                        $completionRow['Percentage']=0;
                        $output .= '<td>0</td>';
                    }
                        
                    else {
                        $output .= '<td>' . $completionRow["Percentage"] . '</td>';
                        $categoryTotal+=$completionRow["Percentage"];
                        $tempCourse=$course;
                    }
                    $levelInsertSql="insert into levelScore(username,course_name,total)
                    values('".$row['username']."','".$course."','".$completionRow['Percentage']."');";
                    $levelInsertResult = $conn->query($levelInsertSql);
                }
            } else {
                $output .= '<td>0</td>';
            }
        }
        $output .= '<td>'.$categoryTotal.'</td>';

        $parts = explode(' - ', $tempCourse);
        $insCourse = $parts[1] . ' - ' . $parts[2];

        $cateInsertSql="insert into categoryScore(username,course_name,total)
            values('".$row['username']."','".$insCourse."','".$categoryTotal."');";
        $cateInsertResult = $conn->query($cateInsertSql);


        $overAllTotal+=$categoryTotal;
        $categoryTotal=0;

        // Test  DS Course
foreach ($tdscourses as $course) {
            $completionQuery = "SELECT username, ROUND(SUM(grade) / (COUNT(course_name) * 100), 2) * 100 AS Percentage  
                                FROM grades 
                                WHERE course_name LIKE '%".$course."%' 
                                AND username = '".$row["username"]."' 
                                AND date = CURDATE() 
                                GROUP BY username;";
            $completionResult = $conn->query($completionQuery);
            if ($completionResult->num_rows > 0) {
                while ($completionRow = $completionResult->fetch_assoc()) {
                    if ($completionRow["Percentage"] == NULL){
                        $completionRow['Percentage']=0;
                        $output .= '<td>0</td>';
                    }
                        
                    else {
                        $output .= '<td>' . $completionRow["Percentage"] . '</td>';
                        $categoryTotal+=$completionRow["Percentage"];
                        $tempCourse=$course;
                    }
                    $levelInsertSql="insert into levelScore(username,course_name,total)
                    values('".$row['username']."','".$course."','".$completionRow['Percentage']."');";
                    $levelInsertResult = $conn->query($levelInsertSql);
                }
            } else {
                $output .= '<td>0</td>';
            }
        }
        $output .= '<td>'.$categoryTotal.'</td>';

        $parts = explode(' - ', $tempCourse);
        $insCourse = $parts[1] . ' - ' . $parts[2];

        $cateInsertSql="insert into categoryScore(username,course_name,total)
            values('".$row['username']."','".$insCourse."','".$categoryTotal."');";
        $cateInsertResult = $conn->query($cateInsertSql);


        $overAllTotal+=$categoryTotal;
        $categoryTotal=0;

        // Test  DB Course
foreach ($tdbcourses as $course) {
            $completionQuery = "SELECT username, ROUND(SUM(grade) / (COUNT(course_name) * 100), 2) * 100 AS Percentage  
                                FROM grades 
                                WHERE course_name LIKE '%".$course."%' 
                                AND username = '".$row["username"]."' 
                                AND date = CURDATE() 
                                GROUP BY username;";
            $completionResult = $conn->query($completionQuery);
            if ($completionResult->num_rows > 0) {
                while ($completionRow = $completionResult->fetch_assoc()) {
                    if ($completionRow["Percentage"] == NULL){
                        $completionRow['Percentage']=0;
                        $output .= '<td>0</td>';
                    }
                        
                    else {
                        $output .= '<td>' . $completionRow["Percentage"] . '</td>';
                        $categoryTotal+=$completionRow["Percentage"];
                        $tempCourse=$course;
                    }
                    $levelInsertSql="insert into levelScore(username,course_name,total)
                    values('".$row['username']."','".$course."','".$completionRow['Percentage']."');";
                    $levelInsertResult = $conn->query($levelInsertSql);
                }
            } else {
                $output .= '<td>0</td>';
            }
        }
        $output .= '<td>'.$categoryTotal.'</td>';

        $parts = explode(' - ', $tempCourse);
        $insCourse = $parts[1] . ' - ' . $parts[2];

        $cateInsertSql="insert into categoryScore(username,course_name,total)
            values('".$row['username']."','".$insCourse."','".$categoryTotal."');";
        $cateInsertResult = $conn->query($cateInsertSql);


        $overAllTotal+=$categoryTotal;
        $categoryTotal=0;

        // Test  OOPS Course
foreach ($toopcourses as $course) {
            $completionQuery = "SELECT username, ROUND(SUM(grade) / (COUNT(course_name) * 100), 2) * 100 AS Percentage  
                                FROM grades 
                                WHERE course_name LIKE '%".$course."%' 
                                AND username = '".$row["username"]."' 
                                AND date = CURDATE() 
                                GROUP BY username;";
            $completionResult = $conn->query($completionQuery);
            if ($completionResult->num_rows > 0) {
                while ($completionRow = $completionResult->fetch_assoc()) {
                    if ($completionRow["Percentage"] == NULL){
                        $completionRow['Percentage']=0;
                        $output .= '<td>0</td>';
                    }
                        
                    else {
                        $output .= '<td>' . $completionRow["Percentage"] . '</td>';
                        $categoryTotal+=$completionRow["Percentage"];
                        $tempCourse=$course;
                    }
                    $levelInsertSql="insert into levelScore(username,course_name,total)
                    values('".$row['username']."','".$course."','".$completionRow['Percentage']."');";
                    $levelInsertResult = $conn->query($levelInsertSql);
                }
            } else {
                $output .= '<td>0</td>';
            }
        }
        $output .= '<td>'.$categoryTotal.'</td>';

        $parts = explode(' - ', $tempCourse);
        $insCourse = $parts[1] . ' - ' . $parts[2];

        $cateInsertSql="insert into categoryScore(username,course_name,total)
            values('".$row['username']."','".$insCourse."','".$categoryTotal."');";
        $cateInsertResult = $conn->query($cateInsertSql);

        $overAllTotal+=$categoryTotal;
        $categoryTotal=0;

        $output .= '<td>'.$overAllTotal.'</td></tr>';
        $overAllTotal=0;
    }
} else {
    $output .= '<tr><td colspan="48">No Data Found</td></tr>';
}

$output .= '</tbody></table></body></html>';

echo $output;
?>
