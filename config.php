<?php
// Database configuration

$serverName = "localhost"; // server
$username = "root"; // MySQL username
$password = ""; // MySQL password
$database = "auctionsystem"; // Database name

// Establish the connection

$conn = new mysqli($serverName, $username, $password, $database);

// Check if the connection was successful

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    
    // echo "Connection established.<br />";
}

?>
