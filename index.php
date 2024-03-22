<?php
session_start();

include('db.php');

$userprofile = $_SESSION['username'];

if($userprofile == true)
{
    // Continue displaying the page
}
else
{
    header('Location: main.php'); // Corrected redirection
    exit(); // Ensure to exit after redirection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crops and Trees Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header .welcome {
            margin-right: 20px;
            font-weight: bold;
        }

        header .logout {
            background-color: white;
            color: #4CAF50;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid #4CAF50;
        }

        header .logout:hover {
            background-color: #4CAF50;
            color: white;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .card img {
            width: 100%;
            height: auto;
            border-radius: 10px 10px 0 0;
        }

        .card-content {
            padding: 20px;
        }

        h2 {
            margin-top: 0;
        }

        p {
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <div class="welcome">
            <?php echo "Welcome $userprofile"; ?>
        </div>
        <div>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </header>
    <div class="container">
        <div class="card">
            <img src="GM-wheat.jpg" alt="Wheat Field">
            <div class="card-content">
                <h2>Wheat</h2>
                <p>Wheat is a cereal grain that is a staple food in many parts of the world. It is an important crop used to make flour for bread, pasta, and other food products.</p>
            </div>
        </div>
        <div class="card">
            <img src="apple_tree.jpg" alt="Apple Tree">
            <div
