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

    $whereClause = $groupbyClause= '';
    
    if ($batch != "All") {
        if ($whereClause == '') {
            $whereClause = " WHERE batch = '".$batch."'";
            $groupbyClause =' u.batch';
        }
        else{
            $whereClause .= " AND batch = '".$batch."'";
            $groupbyClause .=',u.batch';
        } 
        
    }

    if ($department != "All") {
        if ($whereClause == ''){
            $whereClause = " WHERE department = '".$department."'";
            $groupbyClause = " u.department";
        } 
        else{
            $whereClause .= " AND department = '".$department."'";
            $groupbyClause .= ",u.department";
        } 
    }

    if ($institution != "All") {
        if ($whereClause == ''){
            $whereClause = " WHERE institution = '".$institution."'";
            $groupbyClause = " u.institution";
        } 
        else{
            $whereClause .= " AND institution = '".$institution."'";
            $groupbyClause .=",u.institution";
        } 
    }

    if ($graduation_year != "All") {
        if ($whereClause == ''){
            $whereClause = " WHERE graduation_year = '".$graduation_year."'";
            $groupbyClause =" u.graduation_year";
        } 
        else{
            $whereClause .= " AND graduation_year = '".$graduation_year."'";
            $groupbyClause .=",u.graduation_year";
        } 
    }

    if ($section != "All") {
        if ($whereClause == ''){
            $whereClause = " WHERE section = '".$section."'";
            $groupbyClause =" u.section";
        } 
        else{
            $whereClause .= " AND section = '".$section."'";
            $groupbyClause .=",u.section";
        } 
    }

    if ($programming != "All") {
        if ($whereClause == ''){
            $whereClause = " WHERE programming = '".$programming."'";
            $groupbyClause =" u.programming";
        } 
        else{
            $whereClause .= " AND programming = '".$programming."'";
            $groupbyClause .=",u.programming";
        } 
    }
// 1. Over ALL completion
    $studentListSql = "SELECT DISTINCT username, CONCAT(firstname, ' ', lastname) AS fullname, institution,
                        department, section, graduation_year, batch, programming 
                        FROM users";
    $studentListSql .= $whereClause;
    $studentListSql .= $groupbyClause;

    echo $studentListSql;

?>