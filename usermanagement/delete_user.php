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
    $userId = $_POST['Bidder_Id'];

    // Delete query
    $sql = "DELETE FROM registeredbidder WHERE Bidder_Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
