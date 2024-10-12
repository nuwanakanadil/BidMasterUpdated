<?php

// Start session
session_start();

require_once '../config.php';
require_once '../functions.php';

if (isset($_POST["submit"])) {
   
    // Assign user-entered values to PHP variables
    $username = $_POST["user-name"];
    $psw = $_POST["password"];
   
    // Calling error handling functions with parameters and assigning returned values to PHP variables
    $emptyFields = emptyLogin($username, $psw);

    // Error handling
    if ($emptyFields !== false) {
        // If input sections are empty, system indicates an alert and exits from the login process.
        echo "<script>alert('emptyinputs');
        window.location.href = 'Login.html';
        </script>";
        exit();
    }

    // Create SQL query to fetch username and its password in the database and execute it using mysqli
    $sql = "SELECT Password FROM registeredbidder WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);  // Bind username parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $datarow = $result->fetch_assoc(); // Fetch associative array from query result
        
        
        $hashed_password_from_db = $datarow['Password']; //get hashed password from database
        
        
        // Check if user-entered password matches the password from the database

        if (password_verify($psw, $hashed_password_from_db)) { //verify hashed password and user entered password

            // If the password is correct, assign session variables

            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;

            echo "<script>alert('Login Successful!');
            window.location.href = '../homesigned/home.php';
            </script>";
        } else {

            // If the password is incorrect, alert the user and exit the login process

            echo "<script>alert('Invalid password. Try again.');
            window.location.href = 'Login.html';
            </script>";
            exit();
        }
    } else {

        // If the username is incorrect, alert the user and exit the login process
        
        echo "<script>alert('Invalid User. Please register and try again.');
        window.location.href = '../Signup/signup.html';
        </script>";
        exit();
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

?>


