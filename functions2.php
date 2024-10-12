<?php
require_once 'config.php';

// Function to check for empty input fields during password reset
function emptyChangePsw($username, $new_password, $re_new_password) {
    if (empty($username) || empty($new_password) || empty($re_new_password)) {
        return true;
    }
    return false;
}

// Function to check if new password matches with the re-entered password
function pswmatch($new_password, $re_new_password) {
    return $new_password !== $re_new_password;
}

// Function to check if the new password already exists in the database
function checkAdminPasswordExists($new_password, $conn) {
    $sql = "SELECT COUNT(*) as count FROM admin WHERE password_hash = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    // Hash the password and check if it already exists in the database
    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt->bind_param("s", $hashed_new_password);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Close the statement
    $stmt->close();

    // Return true if the password exists
    return $row['count'] > 0;
}
?>
