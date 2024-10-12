<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'auctionsystem');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// Get data from POST request
$adminId = $_POST['adminId'];  // The hidden field for adminId, will be empty for new users
$fName = $_POST['fName'];
$lName = $_POST['lName'];
$uName = $_POST['uName'];
$email = $_POST['email'];
$role = isset($_POST['role']) ? $conn->real_escape_string($_POST['role']) : 'Admin'; // Default to 'Admin'
$status = isset($_POST['status']) ? $conn->real_escape_string($_POST['status']) : 'Active'; // Default to 'Active'

if (!empty($adminId)) {
    // Update existing user
    $sql = "UPDATE admin SET first_name=?, last_name=?, username=?, role=?, status=?, email=? WHERE admin_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $fName, $lName, $uName, $role, $status, $email, $adminId);
} else {
    // Insert new user
    $sql = "INSERT INTO  admin(first_name, last_name, username, role, status, email) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $fName, $lName, $uName, $role, $status, $email);
}

if ($stmt->execute()) {
    header('Location: admin_management.php');  // Redirect back to the main page after update/insert
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
