<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'auctionsystem');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['id'])) {
    $itemId = $_POST['id'];

    // Delete associated images from item_images
    $deleteImageSql = "DELETE FROM item_images WHERE Item_ID = ?";
    $stmtImage = $conn->prepare($deleteImageSql);
    $stmtImage->bind_param('i', $itemId);

    // Delete item from seller_item
    $sql = "DELETE FROM seller_item WHERE Item_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $itemId);

    
    

    // Execute both queries and check for success
    if ($stmtImage->execute() && $stmt->execute()) {
        echo "Item declined and removed.";
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the prepared statements
    $stmtImage->close();
    $stmt->close();
    
} else {
    echo "No ID received.";
}

$conn->close();
?>
