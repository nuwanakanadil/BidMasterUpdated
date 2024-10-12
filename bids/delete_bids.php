<?php
if (isset($_POST['id'])) {
    $bid_id = $_POST['id'];
    $conn = new mysqli('localhost', 'root', '', 'auctionsystem');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Step 1: Get the Item_ID from the bids table using the bid_id
    $getItemIdSQL = "SELECT Item_ID FROM bids WHERE bid_id = ?";
    $stmt = $conn->prepare($getItemIdSQL);
    $stmt->bind_param("i", $bid_id);
    $stmt->execute();
    $stmt->bind_result($item_id);
    $stmt->fetch();
    $stmt->close();

    if ($item_id) {
        // Step 2: Delete the bid from the bids table
        $deleteBidSQL = "DELETE FROM bids WHERE bid_id = ?";
        $stmt = $conn->prepare($deleteBidSQL);
        $stmt->bind_param("i", $bid_id);
        $stmt->execute();
        $stmt->close();

        // Step 3: Delete the item from the bid_items table using the Item_ID
        $deleteItemSQL = "DELETE FROM bid_items WHERE Item_ID = ?";
        $stmt = $conn->prepare($deleteItemSQL);
        $stmt->bind_param("i", $item_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Bid with ID $bid_id and associated item have been deleted.";
        } else {
            echo "Item not found in bid_items.";
        }

        $stmt->close();
    } else {
        echo "Bid not found.";
    }

    $conn->close();
}
?>
