<?php
// delete.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'auctionsystem');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user ID from POST request
    $adminId = $_POST['admin_id'];

    // Delete query
    $sql = "DELETE FROM admin WHERE admin_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $adminId);

    if ($stmt->execute()) {
        echo "Admin deleted successfully.";
    } else {
        echo "Error deleting admin: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
