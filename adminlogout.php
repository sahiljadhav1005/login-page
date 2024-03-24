<?php
session_start(); // Start the session
session_destroy(); // Destroy the session
header("Location: ../main/main.php"); // Redirect to the main page
exit(); // Ensure script execution stops after redirection

