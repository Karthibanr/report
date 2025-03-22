<?php
// Database connection details
$host = "localhost";  
$user = "root";       
$password = "password";       
$database = "report"; 

// Create a single database connection
$conn = new mysqli($host, $user, $password, $database);

// Fetch the data from the password_Details table in the report database
$query = "SELECT * FROM password_Details"; // Replace this with your actual table name if necessary
$result = $conn->query($query);

if (!$result) {
    die('Error fetching data: ' . $conn->error);
}

// Start HTML structure
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Passcode Details</title>

    <!-- Include DataTable CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- Include DataTable Buttons CSS (for Excel and PDF export) -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

    <!-- Include jQuery (required by DataTable) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include DataTable JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Include DataTable Buttons JS (for export functionality) -->
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>

    <!-- Include JSZip (for Excel export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <!-- Include PDFMake (for PDF export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <style>
        /* Center-align the table and apply border */
        table {
            margin: 0 auto; /* Center the table */
            border: 1px solid black; /* Apply a border to the table */
            border-collapse: collapse; /* Collapse borders */
            width: 80%; /* Adjust the width as needed */
        }

        /* Style for table headers */
        th {
            background-color: #f2f2f2;
            text-align: center; /* Center-align the header text */
            padding: 10px;
        }

        /* Style for table data */
        td {
            text-align: center; /* Center-align the data */
            padding: 8px;
            border: 1px solid black; /* Apply border around each cell */
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize the DataTable
            $("#passwordTable").DataTable({
                "paging": true,  // Enable pagination
                "searching": true,  // Enable search
                "ordering": true,  // Enable sorting
                "pageLength": 100 // Default page length
            });
        });
    </script>
</head>
<body>';

echo '<h2 style="text-align: center;">Test Password Details</h2>';

echo '<table id="passwordTable" class="display" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Assessment Name</th>
                <th>Password</th>
                <th>Quit Password</th>
            </tr>
        </thead>
        <tbody>';

// Loop through each row and output the data as table rows
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['course_name'] . '</td>'; // Assuming the column name is 'course_name'
    echo '<td>' . $row['assessment_name'] . '</td>'; // Assuming the column name is 'assessment_name'
    echo '<td>' . $row['password'] . '</td>'; // Assuming the column name is 'password'
    echo '<td>' . $row['quit_password'] . '</td>'; // Assuming the column name is 'quit_password'
    echo '</tr>';
}

echo '</tbody></table>';

echo '</body>
</html>';

// Close the database connection
$conn->close();
?>
