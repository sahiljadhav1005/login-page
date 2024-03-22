<?php
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

$newPasswordMessage = ''; // Variable to store the new password message

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email is provided
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        // Sanitize email input
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        // Validate email format
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Check if the email exists in the database
            $sql_email = "SELECT * FROM form WHERE email = '$email'";
            $result_email = $conn->query($sql_email);

            if ($result_email->num_rows > 0) {
                // Email exists, check if userid is also provided
                if (isset($_POST['userid']) && !empty($_POST['userid'])) {
                    // Sanitize userid input
                    $userid = filter_var($_POST['userid'], FILTER_SANITIZE_STRING);

                    // Example validation: Check if userid is numeric
                    if (!is_numeric($userid)) {
                        $newPasswordMessage .= " Invalid user ID format. Please provide a valid user ID.";
                    } else {
                        // Check if the userid and email belong to the same user
                        $sql_userid = "SELECT * FROM form WHERE email = '$email' AND userid = '$userid'";
                        $result_userid = $conn->query($sql_userid);
                        if ($result_userid->num_rows > 0) {
                            // Both email and userid match, proceed to reset password
                            header("Location: update_password.php?email=" . urlencode($email) . "&userid=" . urlencode($userid));
                            exit();
                        } else {
                            // Userid provided does not match the email
                            $newPasswordMessage .= " User ID does not match the provided email.";
                        }
                    }
                } else {
                    // Userid not provided
                    $newPasswordMessage .= " Please provide your user ID.";
                }
            } else {
                // Email does not exist
                $newPasswordMessage = "User not found. Please check your email and try again.";
            }
        } else {
            // Invalid email format
            $newPasswordMessage = "Invalid email format. Please provide a valid email address.";
        }
    } else {
        // Email not provided
        $newPasswordMessage = "Please provide your email address.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="forgot.css">
    <!-- Internal CSS -->
    <style>
        .password-message {
            margin-top: 50px;
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .success-message {
            background-color: rgba(144, 238, 144, 0.5); /* Light green color with 50% opacity */
        }
    </style>
</head>

<body>
    <header>
        <h1>Forgot Password</h1>
    </header>
    <nav>
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
    </nav>
    <section>
        <h2 style="text-align: center;">Reset Password</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            <br>
            <label for="userid">User ID:</label>
            <input type="text" id="userid" name="userid">
            <br>
            <input type="submit" value="Reset Password">
        </form>
        <p style="text-align: center;">Remembered your password? <a href="main.php">Go back to login</a></p>
        <?php if (!empty($newPasswordMessage)): ?>
        <div class="password-message success-message">
            <?php echo $newPasswordMessage; ?>
        </div>
        <?php endif; ?>
    </section>
    <footer>
        <p>&copy; 2024 MyWebsite. All rights reserved.</p>
    </footer>
</body>

</html>
