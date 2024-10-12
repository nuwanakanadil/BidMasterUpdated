<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: ../Login/Login.html");
    exit();
}
?>

<html>
<head>
    <title>BidMaster</title>
    <link rel="stylesheet" href="home.css">
    <script>
        function toggleVideoSound() {
            const video = document.getElementById('background-video');
            const soundButton = document.querySelector('.sound-btn');

            if (video.muted) {
                video.muted = false; // Unmute the video
                soundButton.innerText = 'Mute Sound'; // Change button text
            } else {
                video.muted = true; // Mute the video
                soundButton.innerText = 'Play with Sound'; // Revert button text
            }
        }

        //function to load home page
        function RedirectToHome() {
            window.location.href = '../home.html';
        }
    </script>
</head>
<body>
   
    <video autoplay muted loop id="background-video">
        <source src="../video.mp4" type="video/mp4">
    </video>
    <div class="overlay">
        <header>
            <nav>
                <a href="../homesigned/home.html"><i class="fas fa-home"></i> Home</a> /
                <a href="../AboutUs/About.html"><i class="fas fa-info-circle"></i> About</a> /
                <a href="../ContactUs/ContactUs.html"><i class="fas fa-envelope"></i> Contact Us</a>
                <a href="profile.php"><i class="fas fa-envelope"></i>Your Profile</a>
            </nav>
            <div class="sign-buttons">
                <button class="btn" id="logout" onclick="RedirectToHome()">Log Out</button>
            </div>
        </header>
        <hr>
        <h1>Welcome to <span class="highlight">BidMaster</span></h1>
        <p>Unlock the Power of Online Auctions with <span class="highlight">BidMaster!</span></p>
        <a href="../UserHomepage/index.php" class="browse-item-btn">Browse Items</a><br>
        <a href="../SellerHomepage/seller.php" class="switch-seller-btn">Switch to Seller Mode</a><br>
        
    </div>
    <button onclick="toggleVideoSound()" class="sound-btn">Play with Sound</button>
</body>
</html>
