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
        $sql = "SELECT id, username, password FROM sietlms_user WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $user);
        $stmt->execute();

        // Check if a user exists
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            // Verify the password (Stores passwords as hashes)
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .error {
            color: #f44336;
            margin: 20px 0;
            font-size: 14px;
        }

        .forgot-password {
            font-size: 14px;
            color: #4CAF50;
            text-decoration: none;
            margin-top: 10px;
            display: inline-block;
        }

        .forgot-password:hover {
            text-decoration: underline;
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
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
