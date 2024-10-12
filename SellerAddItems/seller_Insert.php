<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'auctionsystem');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$Iusername = isset($_POST["username"]) ? $_POST["username"] : '';
$Icondition = $_POST["condition"];
$Ibrand = $_POST["brand"];
$Imodel = $_POST["model"];
$Iprice = $_POST["price"];
$Idescription = $_POST["description"];

if (isset($_FILES['image'])) {
    $image = $_FILES['image']['name'];
    $tempPath = $_FILES['image']['tmp_name']; // Temporary file path
    $target1 = "uploads/" . basename($image); // First target folder
    $target2 = "../bids/uploads/" . basename($image); // Second target folder
    $target3 = "../UserHomepage/uploads/" . basename($image);//Third target folder
    $target4 = "../SellerHomepage/uploads/" . basename($image);//Fourth target folder
    $target5 = "../homesigned/uploads/" . basename($image);//Fifth target folder

    // Insert item details into seller_item table
    $sql = "INSERT INTO seller_item (seller_username, Conditions, Brand, Model, Price, Description) VALUES ('$Iusername', '$Icondition', '$Ibrand', '$Imodel', '$Iprice', '$Idescription')";
    
    if ($conn->query($sql) === TRUE) {
        // Get the ID of the inserted item
        $lastItemId = $conn->insert_id;

        // Upload the image to the first folder
        if (move_uploaded_file($tempPath, $target1)) {
            // Copy the image to the second folder
            if (copy($target1, $target2)) {
                // Copy the image to the third folder
                if (copy($target1, $target3)) {
                    //copy the image to the fourth folder
                    if (copy($target1, $target4)) {
                    //copy the image to the fifth folder
                        if (copy($target1, $target5)) {
                    // Insert the image path into the item_images table, linked to the inserted Item_ID
                    $sqlImage = "INSERT INTO item_images (Item_ID, image_path) VALUES ('$lastItemId', '$target1')";

                    if ($conn->query($sqlImage) === TRUE) {
                        header("Location: ../SellerHomepage/seller.php");
                        exit();
                    } else {
                        echo "Error: " . $sqlImage . "<br>" . $conn->error;
                    }
                } else {
                    echo "Failed to copy image to the second folder.";
                }
            } else {
                echo "Failed to upload image to the first folder.";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "No image uploaded.";
    }
}
}
}
// Close the database connection
$conn->close();
?>