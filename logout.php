<?php
session_start(); // Start the session first
session_unset(); // Optional: remove all session variables
session_destroy(); // Destroy the session

header("Location: admin_login.php"); // Redirect to login page
exit;
?>
