<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch data from the "form" table
$query = "SELECT sno, username, email, userid FROM form"; // Include "userid" column in the query
$result = $con->query($query);

// Close connection
$con->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- External CSS -->
    <link rel="stylesheet" href="admin.css">
    <style>
        .home-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .home-btn:hover {
            background-color: #45a049; /* Darker green */
        }
    </style>
</head>

<body>
    <a href="../main/main.php" class="home-btn" onclick="endSession()">Go to Home</a>
    <div class="container">
        <img class="logo" src="logo.jpg" alt="Logo">
        <h1>Admin Page</h1>
        <table>
            <thead>
                <tr>
                    <th>Sno</th>
                    <th>Userid</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th> <!-- Added Action column for delete button -->
                </tr>
            </thead>
            <tbody>
                <?php
                include("db.php");

                // Display data fetched from the database
                $sql = "SELECT * FROM form";
                $result = mysqli_query($con, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["sno"] . "</td>";
                        echo "<td>" . $row["userid"] . "</td>";
                        echo "<td>" . $row["username"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        // Delete button with form for each row
                        echo "<td><form method='POST'><input type='hidden' name='delete_id' value='" . $row["sno"] . "'><button type='submit' class='delete-btn'>Delete</button></form></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No data found</td></tr>"; // Update colspan to include new column
                }

                // Handle delete action
                if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete_id'])) {
                    $delete_id = $_POST['delete_id'];
                    $delete_query = "DELETE FROM form WHERE sno = ?";
                    $stmt = $con->prepare($delete_query);
                    $stmt->bind_param("i", $delete_id);

                    if ($stmt->execute()) {
                        echo "<script>alert('Row deleted successfully');</script>";
                        header("Location: admin.php");
                        exit();
                    } else {
                        echo "<script>alert('Error deleting row');</script>";
                    }

                    $stmt->close();
                }

                mysqli_close($con);
                ?>
            </tbody>
        </table>
    </div>

    <script>
    function endSession() {
        // Redirect to a PHP script that handles session destruction
        window.location.href = "adminlogout.php";
    }
    </script>

</body>

</html>
