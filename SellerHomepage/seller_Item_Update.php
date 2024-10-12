<?php

// Database connection
$conn = new mysqli('localhost', 'root', '', 'auctionsystem');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$Icondition = $_POST["condition"];
$Ibrand = $_POST["brand"];
$Imodel = $_POST["model"];
$Iprice = $_POST["price"];
$Idescription = $_POST["description"];
$ItemID = $_POST["itemID"];

if(empty($Icondition)||empty($Ibrand)||empty($Imodel)||empty($Iprice)||empty($Idescription)){

    echo "All required";
}
else{
     $updateItemSQL = "UPDATE  bid_items set Conditions='$Icondition', Brand='$Ibrand', Model='$Imodel', Price='$Iprice', Description='$Idescription' WHERE Item_ID = '$ItemID'";
     $updateBidSQL = "UPDATE bids 
                     SET highest_bid = '$Iprice', started_bid = '$Iprice' 
                     WHERE Item_ID = '$ItemID'";

if ($conn->query($updateItemSQL) === TRUE && $conn->query($updateBidSQL) === TRUE) {
    header("Location: seller.php");

} else {
    echo "Error updating item: " . $conn->error;
}
}

?>