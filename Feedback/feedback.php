<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "auctionsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    if (isset($_POST['submit'])) {
        // Sanitize input
        $user_name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $message = $conn->real_escape_string($_POST['message']);

        // Insert into the database
        $sql = "INSERT INTO feedback (username, email, message) VALUES('$user_name', '$email', '$message')";
        
        // Execute the query and check for success
        if ($conn->query($sql) === TRUE) {
            echo "Thank you for your feedback!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the connection
$conn->close();
?>
