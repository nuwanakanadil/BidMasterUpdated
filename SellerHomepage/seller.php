

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Page</title>
    <!-- Link to external CSS files for styling -->
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="seller.css"> <!-- Additional CSS for seller page styling -->
</head>
<body>
    <!-- Main container for the content -->
    <div class="container">
    
    <!-- Header section with logo and navigation links -->
    <header>
        <img src="../logo.jpg" alt="Logo" class="logo">
        <nav>
            <a href="../homesigned/home.php"><i class="fas fa-home"></i>Home</a> /
            <a href="../AboutUs/About.html"><i class="fas fa-info-circle"></i>About</a> /
            <a href="../ContactUs/ContactUs.html"><i class="fas fa-envelope"></i>Contact Us</a>
        </nav>
    </header>
    <hr> <!-- Horizontal rule for separation -->

    <!-- Button for posting a new item, centered on the page -->
    <center>
        <a href="../SellerAddItems/selleritem.html"><button class="custom-button"><b>POST YOUR ITEM</b></button></a>
        <br><br>

        <!-- Include the PHP file to display seller items -->
        <?php include 'seller_Item_Read.php'; ?>
    </center>

    <div class="form-container" id="itemForm" style="display: none;">
        <h1>Add Item for Sale</h1>
        <form method="post" action="seller_Item_Update.php" enctype="multipart/form-data">

            <!-- Hidden input for Item ID -->
            <input type="hidden" id="itemID" name="itemID"> <!-- Hidden field for Item_ID -->


            <!-- Dropdown for selecting item condition -->
            <b>Condition:</b>
            <select id="condition" name="condition" required>
                <option value="new">New</option>
                <option value="used">Used</option>
            </select>

            <!-- Input for item brand -->
            <b>Brand:</b>
            <input type="text" id="brand" name="brand" required>

            <!-- Input for item model -->
            <b>Model:</b>
            <input type="text" id="model" name="model" required>

            <!-- Textarea for item description -->
            <b>Description:</b>
            <textarea id="description" name="description" rows="4" cols="20" required></textarea>

            <!-- Input for item price -->
            <b>Price:</b>
            <input type="number" id="price" name="price" required>

            

            <!-- Submit button to add the item -->
            <button type="submit" value="Add Item">Update Item</button>
        </form>
    </div>

    <!-- Footer section with additional navigation and social media links -->
    <footer>
        <nav class="footer-nav">
            <ul>
                <li><a href="../homesigned/home.php">Home</a></li>
                <li><a href="../AboutUs/About.html">About us</a></li>
                <li><a href="../ContactUs/ContactUs.html">Contact us</a></li>
            </ul>
            
        </nav>
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
            <p>&copy; 2024 BIDMASTER ONLINE AUCTION. All rights reserved</p>
            <div class="legal-links">
                <a href="../FAQs/faq.html">FAQs</a>
                <a href="../PrivacyPage/privacy page.html">Privacy Policy</a>
            </div>
        </div>
    </footer>
    <script>
        function loadItemForUpdate(button) {
        // Show the form
        document.getElementById('itemForm').style.display = 'block';

        // Populate the form fields with the item data from the button's data attributes
        document.getElementById('itemID').value = button.getAttribute('data-id');
        document.getElementById('condition').value = button.getAttribute('data-condition');
        document.getElementById('brand').value = button.getAttribute('data-brand');
        document.getElementById('model').value = button.getAttribute('data-model');
        document.getElementById('description').value = button.getAttribute('data-description');
        document.getElementById('price').value = button.getAttribute('data-price');
        
        }
    </script>
</body>
</html>
