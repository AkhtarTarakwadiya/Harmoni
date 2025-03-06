<?php
// Database Connection
$servername = "localhost";
$username = "root"; // Change if different
$password = ""; // Change if needed
$database = "harmoni"; // Change to your actual database name

$conn = mysqli_connect($servername, $username, $password, $database);

// Check Connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
