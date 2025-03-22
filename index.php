<?php

$host = 'localhost';
$dbname = 'siet_lms';
$username = 'root';
$password = 'password';

// Start the session
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the username and password from the login form
    $user = $_POST['username'];
    $pass = $_POST['password'];

    try {
        // Create a PDO instance for database connection
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL query to fetch the user by username
        $sql = "SELECT id, username, password FROM mdl_user WHERE username = :username";
        $sql = "SELECT id, username, password FROM sietlms_user WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $user);
        $stmt->execute();

        // Check if a user exists
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            // Verify the password (stores passwords as hashes)
            if (password_verify($pass, $userData['password'])) {
                // Store user data in session for use in other pages
                $_SESSION['user_id'] = $userData['id'];
                $_SESSION['username'] = $userData['username'];

                // Redirect to a protected page (e.g., dashboard)
                header('Location: dashboard.php');
                exit();
            } else {
                $error = 'Invalid password!';
            }
        } else {
            $error = 'User not found!';
        }
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .login-container {
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .login-container h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
