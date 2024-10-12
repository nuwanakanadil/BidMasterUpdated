<?php

require_once 'config.php';

// This function checks for empty input fields in the registration form
function emptyInputSignup($fname, $lname, $username, $email, $address, $nic, $phone_number, $psw, $Reenterpsw) {
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

// This function checks if the username exists in the database registerbidder
function checkUsernameExists($username, $conn) {
    // Prepare a MySQL statement
    $sql = "SELECT COUNT(*) as count FROM registeredbidder WHERE Username = ?";
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

// This function checks if the password exists in the database
function checkPasswordExists($psw, $conn) {
    // Prepare a MySQL statement
    $sql = "SELECT COUNT(*) as count FROM registeredbidder WHERE Password = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    // Bind and execute the query
    $stmt->bind_param("s", $psw);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Close the statement
    $stmt->close();

    // Return true if the password exists, false otherwise
    return $row['count'] > 0;
}

// This function checks if the username exists in the database admin
function checkAdminnameExists($username, $conn) {
    // Prepare a MySQL statement
    $sql = "SELECT COUNT(*) as count FROM admin WHERE Username = ?";
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

// This function checks if the password exists in the database admin
function checkAdminPasswordExists($psw, $conn) {
    // Prepare a MySQL statement
    $sql = "SELECT COUNT(*) as count FROM admin WHERE Password = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error: " . $conn->error);
    }

    // Bind and execute the query
    $stmt->bind_param("s", $psw);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Close the statement
    $stmt->close();

    // Return true if the password exists, false otherwise
    return $row['count'] > 0;
}

?>
