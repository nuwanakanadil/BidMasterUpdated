<?php
require_once '../config.php';
require_once '../functions.php';

if (isset($_POST["submit"])) {
    //Assign user entered values to PHP variables
    $username = $_POST["user-name"];
    $Email = $_POST["email"];
    $new_psw = $_POST["new-password"];
    $re_new_psw = $_POST["re-new-password"];
    

    // Calling error handling functions with parameters and assigning returned values of error handling functions (defined in function.php) to PHP variables
    $emptyInputFields = emptyChangePsw($username, $new_psw, $re_new_psw);
    $newPswMatch = pswmatch($new_psw, $re_new_psw);
    $passwordExists = checkPasswordExists($new_psw, $conn);

    // Error handling
    if ($emptyInputFields !== false) {
        // If input fields are empty, system indicates an alert and exits from the password-changing process.
        echo "<script>alert('emptyinputs');
        window.location.href = '../Login/Login.php?error=emptyinputs';
        </script>";
        exit();
    }
    if ($passwordExists !== false) {
        // If password is already taken, system indicates an alert and exits from the password-changing process.
        echo "<script>alert('Password is already taken. Use a different password');
        window.location.href = 'forgot_psw';
        </script>";
        exit();
    }
    if ($newPswMatch !== false) {
        // If the password and re-entered password don't match, system indicates an alert and exits from the password-changing process.
        echo "<script>alert('Re-entered password is incorrect');
        window.location.href = 'forgot_psw.html';
        </script>";
        exit();
    }

    // SQL query to check if the username exists in the database
    $sql = "SELECT COUNT(*) AS userCount FROM registeredbidder WHERE Username = ? AND Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username,$Email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['userCount'] > 0) {

        // Hash the password before saving it to the database
        $hashed_new_password = password_hash($new_psw,PASSWORD_DEFAULT);

        // Create SQL query to update the password in the database and execute it using mysqli
        $sql = "UPDATE registeredbidder SET Password = ? WHERE Username = ? AND Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $hashed_new_password, $username, $Email);
        $stmt->execute();

        if ($stmt->error) {
            // If there is an error in executing the SQL query, print the error.
            die("Error: " . $stmt->error);
        } else {
            // Give an alert to the user that the password has changed successfully and redirect to the login page.
            echo "<script>alert('Password changed successfully');
            window.location.href = '../Login/Login.html';
            </script>";
        }
    } else {
        // If the username does not exist, alert 'Invalid user'
        echo "<script>
                alert('Invalid user. Please register in the system');
                window.location.href = '../Signup/signup.html';
              </script>";
        exit();
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>
