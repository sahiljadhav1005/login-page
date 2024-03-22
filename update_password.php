<?php

session_start(); // Start the session

// Check if email is not received from forgot.php and no user is logged in
if (!isset($_GET['email']) && !isset($_SESSION['logged_in'])) {
    // Redirect to forgot.php
    header("Location: forgot.php");
    exit; // Stop further execution
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "register";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$updatePasswordMessage = ''; // Variable to store the update password message
$email = ''; // Variable to store the email

// Check if email is received from forgot.php
if (isset($_GET['email'])) {
    $email = $_GET['email'];
} else {
    // Handle the case when email parameter is not present
    echo "Email not provided.";
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if password and confirm password are provided
    if (isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])) {
        // Sanitize password input
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Password validation checks
        if (strlen($password) < 8) {
            $updatePasswordMessage = "Password must be at least 8 characters long.";
        } elseif (!preg_match("/[!@#$%^&*()_+\-=[\]{};':\"\\|,.<>\/?]+/", $password)) {
            $updatePasswordMessage = "Password must contain at least one special character.";
        } elseif ($password !== $confirm_password) {
            $updatePasswordMessage = "Passwords do not match.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Update user's hashed password in the database
            $sql_update = "UPDATE form SET password = ? WHERE email = ?";
            $stmt = $conn->prepare($sql_update);
            $stmt->bind_param("ss", $hashed_password, $email);
            if ($stmt->execute()) {
                $updatePasswordMessage = "Password updated successfully.";
            } else {
                $updatePasswordMessage = "Error updating password: " . $conn->error;
            }
            $stmt->close();
        }
    } else {
        $updatePasswordMessage = "Password and confirm password are required.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>
    <link rel="stylesheet" href="update.css">
    <style>
        #email {
            width: 100%;
            padding: 16px;
            margin-bottom: 30px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        #email:focus {
            border-color: #007bff;
            outline: none;
        }

        .go-to-login {
            position: fixed;
            bottom: 13%;
            right: 46%;
            padding: 10px 20px;
            background-color: blue;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }

        .go-to-login:hover {
            background-color: darkblue;
        }

        .error-message {
            margin-top: 10px;
        }

        .success-message {
            color: blue;
        }

        .error-message-red {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Update Password</h2>
        <form action="#" method="POST">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password">
            <input type="submit" value="Update Password">
        </form>
        <div
            class="error-message <?php echo ($updatePasswordMessage === "Password updated successfully.") ? 'success-message' : 'error-message-red'; ?>">
            <?php echo $updatePasswordMessage; ?>
        </div>
        <a href="main.php" class="go-to-login">Go to login</a>
    </div>
</body>

</html>