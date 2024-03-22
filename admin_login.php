<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            background: url('admin_image.jpg') no-repeat center center fixed;
        }

        .container {
            max-width: 400px;
            margin: 80px auto;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.8);
            /* Semi-transparent white background */
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        label {
            color: #555;
            font-size: 16px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
            background-color: #f9f9f9;
            /* Light gray background */
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 20px 0 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        button:focus {
            outline: none;
        }

        .error-message {
            color: #ff0000;
            font-size: 14px;
            margin-top: 10px;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        /* Navigation styles */
        nav {
            background-color: #555;
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
        }

        /* Change color of links on hover */
        nav a:hover {
            color: lightgreen;
            /* Change to your desired color */
        }
    </style>
    <style>
        /* Additional CSS for aesthetics */
        body {
            background-size: cover;
            /* Ensures the background image covers the entire viewport */
        }

        .container {
            padding: 30px;
            /* Decreased padding for a sleeker look */
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #4CAF50;
            /* Highlight input fields on focus */
        }

        button {
            font-weight: bold;
            /* Make button text bold */
        }
    </style>
</head>

<body>
    <header>
        <h1>ADMIN PAGE</h1>
    </header>
    <nav>
        <a href="#">Home</a>
    </nav>
    <div class="container">
        <h2>Admin Login</h2>
        <form id="loginForm">
            <label for="adminName">Admin Name</label>
            <input type="text" id="adminName" name="adminName" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <p style="text-align: center;" class="error-message" id="errorMessage"></p>
    </div>

    <script>
        document.getElementById("loginForm").addEventListener("submit", function (event) {
            event.preventDefault();
            var adminName = document.getElementById("adminName").value;
            var password = document.getElementById("password").value;
            var errorMessage = document.getElementById("errorMessage");

            if (adminName === "sahil" && password === "sahil@1005") {
                // If credentials are correct, redirect to the admin page
                window.location.href = "admin.php";
            } else {
                errorMessage.textContent = "Invalid admin name or password. Please try again.";
            }
        });
    </script>

</body>

</html>