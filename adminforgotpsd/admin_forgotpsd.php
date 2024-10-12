<?php
require_once '../config.php';
require_once '../functions2.php';

if (isset($_POST["submit"])) {
    // Assign user-entered values to PHP variables
    $username = $_POST["username"];
    $new_psw = $_POST["new_password"];
    $re_new_psw = $_POST["confirm_password"];

    // Call error handling functions
    $emptyInputFields = emptyChangePsw($username, $new_psw, $re_new_psw);
    $newPswMatch = pswmatch($new_psw, $re_new_psw);
    $passwordExists = checkAdminPasswordExists($new_psw, $conn);

    // Error handling
    if ($emptyInputFields) {
        echo "<script>alert('All input fields are required.');
        window.location.href = 'forgot_psw.html?error=emptyinputs';
        </script>";
        exit();
    }
    
    if ($passwordExists) {
        echo "<script>alert('Password is already taken. Please choose a different password.');
        window.location.href = 'forgot_psw.html';
        </script>";
        exit();
    }
    
    if ($newPswMatch) {
        echo "<script>alert('Passwords do not match.');
        window.location.href = 'admin_forgotpsd.html';
        </script>";
        exit();
    }

    // Check if the username exists in the database
    $sql = "SELECT COUNT(*) AS userCount FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['userCount'] > 0) {
        // Hash the password before saving it to the database
        $hashed_new_password = password_hash($new_psw, PASSWORD_DEFAULT);

        // Update the password in the database
        $sql = "UPDATE admin SET password_hash = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $hashed_new_password, $username);
        $stmt->execute();

        if ($stmt->error) {
            die("Error: " . $stmt->error);
        } else {
            echo "<script>alert('Password changed successfully.');
            window.location.href = '../loginadmin/admin_login.html';
            </script>";
        }
    } else {
        echo "<script>alert('Invalid username. Please register.');
        window.location.href = '../registeradmin/register_admin.html';
        </script>";
        exit();
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>