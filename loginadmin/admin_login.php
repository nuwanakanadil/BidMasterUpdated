<?php

// Start session
session_start();

$username = $_SESSION['username'];

// Database connection parameters
$host = 'localhost';
$dbname = 'auctionsystem';
$dbUsername = 'root';
$dbPassword = ''; 

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUsername = trim($_POST['username']);
    $inputPassword = trim($_POST['password']);

    // Validate inputs
    if (empty($inputUsername) || empty($inputPassword)) {
        echo "<script>alert('Username and Password must be filled out.');</script>";
    } else {
        // Query to get the user by username
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :username");
        $stmt->bindParam(':username', $inputUsername);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and verify the password
        if ($user && isset($user['password_hash']) && password_verify($inputPassword, $user['password_hash'])) {
            // If password is correct, redirect to home.html
            header("Location: ../admindashboard/dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid username or password.');
                  window.location.href = '../adminforgotpsd/admin_forgotpsd.html';</script>";;
        }
    }
}
?>


