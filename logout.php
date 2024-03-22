<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header("Location: main.php"); // Redirect to the login page after logout
exit(); // Ensure to exit after redirection
