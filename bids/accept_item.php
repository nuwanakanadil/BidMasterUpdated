<?php
if (isset($_POST['id'])) {
    $itemId = $_POST['id'];
    $conn = new mysqli('localhost', 'root', '', 'auctionsystem');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Get item data from seller_item
        $sql = "SELECT * FROM seller_item WHERE Item_ID = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param('i', $itemId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Get image path from item_images
            $sqlImage = "SELECT image_path FROM item_images WHERE Item_ID = ?";
            $stmtImage = $conn->prepare($sqlImage);
            if (!$stmtImage) {
                throw new Exception("Error preparing image statement: " . $conn->error);
            }
            $stmtImage->bind_param('i', $itemId);
            $stmtImage->execute();
            $resultImage = $stmtImage->get_result();
            $imagePath = '';
            if ($resultImage->num_rows > 0) {
                $imageRow = $resultImage->fetch_assoc();
                $imagePath = $imageRow['image_path'];
            }

            // Move the item to bid_items table, including the image path
            $sqlInsert = "INSERT INTO bid_items (Item_ID, seller_username, Conditions, Brand, Model, Price, Description, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtInsert = $conn->prepare($sqlInsert);
            if (!$stmtInsert) {
                throw new Exception("Error preparing insert statement: " . $conn->error);
            }
            $stmtInsert->bind_param('issssiss', $row['Item_ID'], $row['seller_username'], $row['Conditions'], $row['Brand'], $row['Model'], $row['Price'], $row['Description'], $imagePath);


            // Insert into bids table (with default values for bidding)
            $sqlInsertBid = "INSERT INTO bids (Item_ID, started_bid, highest_bid, started_date, ending_date) VALUES (?, ?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 5 DAY))";
            $started_bid = $row['Price'];
            $highest_bid = $row['Price']; // Assuming starting bid is the initial price
            $stmtInsertBid = $conn->prepare($sqlInsertBid);
            if (!$stmtInsertBid) {
                throw new Exception("Error preparing bid statement: " . $conn->error);
            }
            $stmtInsertBid->bind_param('iii', $row['Item_ID'], $started_bid, $highest_bid);
            

            // Delete the image from item_images after transferring
            $sqlDeleteImage = "DELETE FROM item_images WHERE Item_ID = ?";
            $stmtDeleteImage = $conn->prepare($sqlDeleteImage);
            if (!$stmtDeleteImage) {
                throw new Exception("Error preparing delete image statement: " . $conn->error);
            }
            $stmtDeleteImage->bind_param('i', $itemId);

            // Delete the item from seller_item
            $sqlDelete = "DELETE FROM seller_item WHERE Item_ID = ?";
            $stmtDelete = $conn->prepare($sqlDelete);
            if (!$stmtDelete) {
                throw new Exception("Error preparing delete statement: " . $conn->error);
            }
            $stmtDelete->bind_param('i', $itemId);
            

            // Commit the transaction
            $conn->commit();
            

            if ($stmtInsert->execute() && $stmtInsertBid->execute() && $stmtDeleteImage->execute() && $stmtDelete->execute()) {
            echo "Item accepted successfully.";
            } else {
                echo "Error: " . $conn->error;
            }
            // Close all prepared statements
            $stmt->close();
            $stmtImage->close();
            $stmtInsert->close();
            $stmtInsertBid->close();
            $stmtDelete->close();
            $stmtDeleteImage->close();
        } else {
            echo "Item not found.";
        }
    } catch (Exception $e) {
        // Rollback the transaction in case of any errors
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    $conn->close();
}
?>
