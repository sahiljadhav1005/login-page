<?php
session_start();

include("db.php");

$registrationSuccess = false;
$userId = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    try {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Check if the form has been submitted
        if (isset($_POST['submit'])) {
            // Server-side validation
            if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
                throw new Exception("Please fill in all fields.");
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email format.");
            } elseif ($password !== $confirm_password) {
                throw new Exception("Passwords do not match.");
            } elseif (strlen($password) < 8) {
                throw new Exception("Password must be at least 8 characters long.");
            } elseif (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
                throw new Exception("Username can only contain letters, numbers, and underscores.");
            } else {
                // Check for duplicate username or email
                $check_username_query = "SELECT * FROM form WHERE username='$username'";
                $check_email_query = "SELECT * FROM form WHERE email='$email'";
                $result_username = mysqli_query($con, $check_username_query);
                $result_email = mysqli_query($con, $check_email_query);

                if (mysqli_num_rows($result_username) > 0) {
                    throw new Exception("Username already exists. Please choose a different one.");
                } elseif (mysqli_num_rows($result_email) > 0) {
                    throw new Exception("Email already exists. If you already have an account, please login.");
                } else {
                    // Generate a unique 4-digit user ID
                    $userid = sprintf("%04d", mt_rand(1, 9999));

                    // Hash the password using bcrypt
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Insert new user into the database with hashed password and user ID
                    $query = "INSERT INTO form (userid, username, email, password) VALUES ('$userid', '$username', '$email', '$hashed_password')";
                    if (mysqli_query($con, $query)) {
                        // Registration successful
                        $registrationSuccess = true;
                        $userId = $userid;
                    } else {
                        // Error registering user
                        throw new Exception("Error registering user. Please try again.");
                    }
                }
            }
        }
    } catch (Exception $e) {
        // If any error occurred, display it to the user
        $errorMessage = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="register.css">
    <!-- Internal CSS -->
    <style>
        header {
            background-color: #333;
            color: #fff;
            padding: 23px;
            text-align: center;
        }

        .error {
            color: red;
        }

        #registrationSuccess {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Create an Account</h1>
    </header>
    <nav>
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
    </nav>
    <section>
        <h2 style="text-align: center;">Registration Form</h2>
        <div id="registrationBlock" <?php if ($registrationSuccess) { ?>style="display: none;"<?php } ?>>
            <form id="registrationForm" action="" method="POST" onsubmit="return validateForm()">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username">
                <span id="usernameError" class="error"></span>
                <br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
                <span id="emailError" class="error"></span>
                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <span id="passwordError" class="error"></span>
                <br>
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password">
                <span id="confirmPasswordError" class="error"></span>
                <br>
                <input type="submit" name="submit" value="Register">
            </form>
            <p style="text-align: center;">Already have an account? <a href="main.php">Go back to login</a></p>
    </div>
            <?php if ($registrationSuccess) { ?>
                <div id="registrationSuccess" style="display: block;">
                    <h2>Registration Successful!</h2>
                    <p>Your User ID is:
                        <?php echo $userId; ?>. Please save this User ID.
                    </p>
                    <p>Proceed to <a href="main.php">login</a>.</p>
                </div>
            <?php } ?>
    </section>
    <script>
        // Redirect to main.php when login link is clicked
        document.querySelector("a[href='main.php']").addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default action of link
            window.location.href = "main.php"; // Redirect to main.php
        });
    </script>
    <footer>
        <p>&copy; 2024 MyWebsite. All rights reserved.</p>
    </footer>

    <script src="register.js"></script>
</body>

</html>
