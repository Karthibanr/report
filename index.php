<?php
echo '<form method="POST" action="dashboard.php">';
include 'php/institute.php';
include 'php/graduationYear.php';
include 'php/department.php';
include 'php/section.php';
include 'php/batch.php';
include 'php/programming.php';
echo '<input type="submit" value="Submit">';
echo '</form>';
?>