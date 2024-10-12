<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "auctionsystem";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else {
        if (isset($_POST['submit'])) {
            $email = $conn->real_escape_string($_POST['email']);

            $sql = "SELECT * FROM feedback WHERE email = '$email'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $name = $row['username'];
                    $message = $row['message'];
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="../ContactUs/contact-us-style.css">
    <link rel="stylesheet" href="../ContactUs/cunt-us-img-slide.css">
    <link rel="stylesheet" href="../ContactUs/style.css">
    <link rel="stylesheet" href="../ContactUs/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    .update_container .secondry-line form {
        margin-top: -10%;
    }
    #message {
        height: 10%;

    }
</style>
<body>
    <header style="margin-bottom: -20%;">
        <div class="nav-container">
            <img src="../logo.jpg" alt="Logo" class="logo">
            <nav>
                <a href="../homesigned/home.html"><i class="fas fa-home"></i>Home</a> /
                <a href="../AboutUs/About.html"><i class="fas fa-info-circle"></i>About</a> /
                <a href="../ContactUs/ContactUs.html"><i class="fas fa-envelope"></i>Contact Us</a>
            </nav>
            <button class="profile-btn">profile</button>
        </div>
    </header>
    <div class="update_container">
        <div class="secondry-line">
            <?php if (isset($name) && isset($message)): ?>
                <form action="update.php" method="POST" class="edit-form">
                <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>"><br>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly><br> <!-- Email is readonly for editing -->

                        <label for="message">Message:</label>
                        <textarea name="message" id="message">
                            <?php echo htmlspecialchars($message); ?>
                        </textarea>
                        
                        <br>

                        <input type="submit" name="update" value="Update" class="update-btn">

                </form>
            <?php endif; ?>
        </div>
    </div>
    <footer style="margin-top: 10%;">
        <div class="social-media">
            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
            
        </div>
        <div class="logo-container">
            <img src="../logo.jpg" alt="Logo" class="footer-logo">
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 ONLINE AUCTION. All rights reserved</p>
            <div class="legal-links">
                <a href="../FAQs/faq.html">FAQs</a>
                <a href="../PrivacyPage/privacy page.html">Privacy Policy</a>
            </div>
        </div>
    </footer>

    <script src="../ContactUs/cont-us-img-slide.js"></script>
    <script src="../ContactUs/chatBot.js"></script>
</body>
</html>
