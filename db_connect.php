<!DOCTYPE html>
<?php
$host = 'localhost'; // Your host
$dbusername = 'root'; // Your database username
$dbpassword = ''; // Your database password
$dbname = 'sample'; // Your database name

// Create a connection
$conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Connection is successful, but no message will be displayed
?>