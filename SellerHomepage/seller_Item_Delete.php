<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'auctionsystem');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if Item_ID is set and proceed with deletion
if (isset($_POST['Item_ID'])) {
    $itemId = $_POST['Item_ID'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Delete from bids table
        $sqlBids = "DELETE FROM bids WHERE Item_ID = ?";
        $stmtBids = $conn->prepare($sqlBids);
        $stmtBids->bind_param("i", $itemId);
        
        if (!$stmtBids->execute()) {
            throw new Exception("Error deleting from bids: " . $conn->error);
        }

        // Delete from bid_items table
        $sqlItems = "DELETE FROM bid_items WHERE Item_ID = ?";
        $stmtItems = $conn->prepare($sqlItems);
        $stmtItems->bind_param("i", $itemId);

        if (!$stmtItems->execute()) {
            throw new Exception("Error deleting from bid_items: " . $conn->error);
        }

        // If both deletes are successful, commit the transaction
        $conn->commit();

        echo "Item and associated bids deleted successfully.";

        // Redirect back to the items page (or wherever you want)
        header("Location: seller.php");  // Change to your actual page that lists items
        exit;

    } catch (Exception $e) {
        // If there was an error, rollback the transaction
        $conn->rollback();
        echo "Failed to delete item: " . $e->getMessage();
    }

} else {
    echo "Invalid request.";
}

// Close the connection
$conn->close();
?>
