<?php

 // Database connection
 $conn = new mysqli('localhost', 'root', '', 'auctionsystem');

 // Check connection
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }
// Include database connection configuration

// This function checks for empty input fields in the registration form
function emptyInputSignup($fname, $lname, $username, $email, $phone_number, $psw, $Reenterpsw) {
    if (empty($fname) || empty($lname) || empty($username) || empty($email) || empty($address) || 
        empty($nic) || empty($phone_number) || empty($psw) || empty($Reenterpsw)) {
        return true;
    }
    return false;
}

// This function checks for empty input fields in the Login form
function emptyLogin($username, $psw) {
    if (empty($username) || empty($psw)) {
        return true;
    }
    return false;
}

// This function checks for empty input fields in the password change form
function emptyChangePsw($username, $new_password, $re_new_password) {
    if (empty($username) || empty($new_password) || empty($re_new_password)) {
        return true;
    }
    return false;
}

// This function checks for invalid characters in the username
function invalidUid($username) {
    return !preg_match("/[a-zA-Z0-9]+/", $username);
}

// This function checks if the email is valid
function invalidEmail($email) {
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
}

// This function checks if the password and re-entered password match
function pswmatch($psw, $Reenterpsw) {
    return $psw !== $Reenterpsw;
}

// Function to hash a password securely using bcrypt
function hashPassword($psw) {
    return password_hash($psw, PASSWORD_DEFAULT);
}

// This function checks if the username exists in the RegisteredBidder table
function checkUsernameExists($username, $conn) {
    // Prepare a MySQL statement
    $sql = "SELECT COUNT(*) as count FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    // Bind and execute the query
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Close the statement
    $stmt->close();
    
    // Return true if the username exists, false otherwise
    return $row['count'] > 0;
}

// This function checks if the password exists in the RegisteredBidder table
function checkPasswordExists($psw, $conn) {
    // Prepare a MySQL statement to fetch the password hashes from the table
    $sql = "SELECT password_hash FROM admin";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Loop through all rows and verify the password against each stored hash
    while ($row = $result->fetch_assoc()) {
        if (password_verify($psw, $row['password_hash'])) {
            return true; // Password already exists
        }
    }

    // Close the statement
    $stmt->close();

    // Return false if no matching password is found
    return false;
}

// This function checks if the username exists in the admin table
function checkAdminUsernameExists($username, $conn) {
    // Prepare a MySQL statement
    $sql = "SELECT COUNT(*) as count FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    // Bind and execute the query
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Close the statement
    $stmt->close();
    
    // Return true if the admin username exists, false otherwise
    return $row['count'] > 0;
}

// This function checks if the password exists in the admin table
function checkAdminPasswordExists($new_password, $conn) {
    // Prepare an SQL statement to retrieve password_hash from admin table
    $sql = "SELECT password_hash FROM admin";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Loop through results and verify the new password against stored password hashes
    while ($row = $result->fetch_assoc()) {
        if (password_verify($new_password, $row['password_hash'])) {
            return true;  // Password already exists
        }
    }

    // Close the statement
    $stmt->close();

    // Return false if no matching password is found
    return false;
}

// This function updates the admin password in the database
function updateAdminPassword($username, $new_password_hash, $conn) {
    // Prepare an SQL statement to update the password in the admin table
    $sql = "UPDATE admin SET password_hash = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    // Bind and execute the query
    $stmt->bind_param("ss", $new_password_hash, $username);
    $stmt->execute();

    // Check for errors during execution
    if ($stmt->error) {
        return "Error: " . $stmt->error;
    } else {
        return true;  // Password updated successfully
    }

    // Close the statement
    $stmt->close();
}

?>
