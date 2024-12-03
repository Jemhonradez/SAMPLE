<?php
// Start the session
session_start();

// Destroy all session variables
session_unset();

// Destroy the session itself
session_destroy();

// Redirect the user to the login page (or home page)
header("Location: profile.php"); // Or "index.php" if you want to go back to the homepage
exit();
?>
