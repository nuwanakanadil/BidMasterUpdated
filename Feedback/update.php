<?php
if (isset($_POST['update'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "auctionsystem";

    // Create connection with database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $conn->real_escape_string($_POST['name']);
    $message = $conn->real_escape_string($_POST['message']);
    $email = $conn->real_escape_string($_POST['email']);

    $sql = "UPDATE feedback SET username='$name', message='$message' WHERE email='$email'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully!')</script>";
    } else {
        echo "<script>alert('Error updating record: " . $conn->error . "')</script>" . "" . $conn->error;
    }

    $conn->close();
}
?>
