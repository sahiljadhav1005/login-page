<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$con = new mysqli($servername, $username, $password);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Database name
$dbname = "register";

// Check if the database exists
if (!$con->select_db($dbname)) {
    // Create the database if it doesn't exist
    $create_db_query = "CREATE DATABASE $dbname";
    if ($con->query($create_db_query) === TRUE) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . $con->error;
        exit();
    }
}

// Connect to the newly created database
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if the users table already exists
$table_check_query = "SHOW TABLES LIKE 'form'";
$table_check_result = mysqli_query($con, $table_check_query);

// If the table exists, fetch the result
$table_exists = mysqli_num_rows($table_check_result) > 0;

// If the table doesn't exist, create it
if (!$table_exists) {
    // SQL query to create the users table
    $create_table_query = "CREATE TABLE form (
      sno INT AUTO_INCREMENT PRIMARY KEY,
      username VARCHAR(50) NOT NULL,
      email VARCHAR(100) NOT NULL,
      password VARCHAR(255) NOT NULL
    )";
    mysqli_query($con, $create_table_query);
    echo "Users table created successfully";
}

$con->close();
?>
