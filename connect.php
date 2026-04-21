<?php
$host = "localhost";       // Usually localhost
$username = "root";        // Your database username
$password = "";            // Your database password (empty in XAMPP by default)
$database = "SD";  // Your database name

$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optional success message
// echo "Connected successfully";
?>