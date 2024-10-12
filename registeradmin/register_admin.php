<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Default password for XAMPP
$dbname = "auctionsystem"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data and escape special characters
    $first_name = isset($_POST['first_name']) ? $conn->real_escape_string($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? $conn->real_escape_string($_POST['last_name']) : '';
    $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
    $phone_number = isset($_POST['phone_number']) ? $conn->real_escape_string($_POST['phone_number']) : '';
    $username = isset($_POST['username']) ? $conn->real_escape_string($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $role = isset($_POST['role']) ? $conn->real_escape_string($_POST['role']) : 'Admin'; // Default to 'Admin'
    $status = isset($_POST['status']) ? $conn->real_escape_string($_POST['status']) : 'Active'; // Default to 'Active'

    // Validate that all required fields are filled
    if ($first_name && $last_name && $email && $phone_number && $username && $password && $confirm_password) {
        // Validate that passwords match
        if ($password !== $confirm_password) {
            echo "Passwords do not match!";
            exit;
        }

        // Hash the password for secure storage
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // SQL query to insert data into the 'admins' table
        $sql = "INSERT INTO admin (first_name, last_name, email, phone_number, username, password_hash, role, status) 
                VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$username', '$hashed_password', '$role', '$status')";

        if ($conn->query($sql) === TRUE) {
            header("Location: ../loginadmin/admin_login.html");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Required fields are missing.";
    }

    $conn->close();
}
?>
