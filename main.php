<?php
session_start();
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $query = "SELECT * FROM form WHERE username = ?";
        $stmt = mysqli_prepare($con, $query);
        
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                
                // Verify the password using bcrypt
                if (password_verify($password, $user_data['password'])) {
                    // Set session variables
                    $_SESSION['username'] = $user_data['username'];
                    // Redirect to index.php 
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Invalid username or password.";
                }
            } else {
                $error = "User not found.";
            }
        } else {
            $error = "Error executing query.";
        }
    } else {
        $error = "Please enter username and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Internal CSS -->
    <style>
        header {
            background-color: #333;
            color: #fff;
            padding: 5px;
            text-align: center;
        }
        .error {
            color: red;
            text-align: center;
        }
        .admin-button {
            position: absolute;
            top: 23px;
            left: 25px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }
        .admin-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
    <a href="../admin/admin_login.php" class="admin-button">Admin Login</a>
    <h1>Login Page</h1>
    </header>
    <nav>
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
    </nav>
    <section>
        <h2 style="text-align: center;">Login Form</h2>
        <?php if(isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="#" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <br>
            <input type="submit" value="Login">
        </form>
        <ul>
            <li><a href="forgot.php">Forgot Password?</a></li>
            <li><a href="register.php">Create an Account</a></li>
        </ul>
    </section>
    <footer>
        <p>&copy; 2024 MyWebsite. All rights reserved.</p>
    </footer>
</body>
</html>
