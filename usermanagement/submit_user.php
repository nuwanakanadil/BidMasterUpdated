<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'auctionsystem');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// Get data from POST request
$userId = $_POST['userId'];  // The hidden field for userId, will be empty for new users
$fName = $_POST['fName'];
$lName = $_POST['lName'];
$uName = $_POST['uName'];
$position = $_POST['position'];
$email = $_POST['email'];
$address = $_POST['address'];
$nic = $_POST['nic'];
$phone = $_POST['phone'];

if (!empty($userId)) {
    // Update existing user
    $sql = "UPDATE registeredbidder SET F_Name=?, L_Name=?, UserName=?, Position=?, Email=?, Address=?, NIC=?, Phone_No=? WHERE Bidder_Id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $fName, $lName, $uName, $position, $email, $address, $nic, $phone,  $userId);
} else {
    // Insert new user
    $sql = "INSERT INTO  registeredBidder(F_Name, L_Name, UserName, Position, Email, Address, NIC, Phone_No) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $fName, $lName, $uName, $position, $email, $address, $nic, $phone);
}

if ($stmt->execute()) {
    header('Location: user_management.php');  // Redirect back to the main page after update/insert
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
