<?php
session_start(); // Start the session

date_default_timezone_set('Asia/Colombo');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: ../Login/Login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="../style.css">

   <!-- custom js file link  -->
</head>
<body>
<header>
        <nav>
            <a href="../homesigned/home.php"><i class="fas fa-home"></i> Home</a> /
            <a href="../AboutUs/About.html"><i class="fas fa-info-circle"></i> About</a> /
            <a href="../ContactUs/ContactUs.html"><i class="fas fa-envelope"></i> Contact Us</a>
            
        </nav>
        
    </header>
   
<div class="container">
   <h3 class="title">Our Products</h3>
   <div class="products-container">

   <?php

   // Database connection
   $conn = new mysqli('localhost', 'root', '', 'auctionsystem');

   // Check connection
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }

   // Check if a new bid was submitted
   if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bid_amount']) && isset($_POST['item_id'])) {
         $newBid = (int) $_POST['bid_amount'];
         $itemId = (int) $_POST['item_id'];
         $currentUser = $_SESSION['username']; // Get the current logged-in user

         // Fetch the current highest bid for the item
         $bidCheck = "SELECT highest_bid, username FROM bids WHERE Item_ID = $itemId";
         $bidResult = $conn->query($bidCheck);
               
         if ($bidResult && $bidResult->num_rows > 0) {
            $row = $bidResult->fetch_assoc();
            $currentHighestBid = (int) $row['highest_bid'];
         
               // If the new bid is higher, update the highest bid and username
               if ($newBid > $currentHighestBid) {
                  $updateBid = "UPDATE bids SET highest_bid = $newBid, username = '$currentUser' WHERE Item_ID = $itemId";
                  $conn->query($updateBid);
                  echo "<script>alert('Bid placed successfully');</script>";
               } else {
                  echo "<script>alert('Your bid must be higher than the current highest bid.');</script>";
               }
         }
      }

   // Fetch data from the bid_items table
   $sql = "SELECT bi.Item_ID, bi.Conditions, bi.Brand, bi.Model, bi.Description, bi.image_path, b.highest_bid, b.username, b.ending_date 
            FROM bid_items bi
            LEFT JOIN bids b ON bi.Item_ID = b.Item_ID
             WHERE b.ending_date >= NOW()";

   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
    // Loop through each row and create a product card
    while ($row = $result->fetch_assoc()) {
      $currentTime = new DateTime(); // Current time
      $endingTime = new DateTime($row['ending_date']); // Ending time from the database

      // Calculate the remaining time
      if ($currentTime < $endingTime) {
         $interval = $currentTime->diff($endingTime);
         // Format the remaining time based on days, hours, and minutes
         if ($interval->d > 0) {
            $remainingTime = $interval->format('%d days %h hours %i minutes');
         } else if ($interval->h > 0) {
            $remainingTime = $interval->format('%h hours %i minutes');
         } else {
            $remainingTime = $interval->format('%i minutes');
         }
      } else {
         $remainingTime = 'Expired';
      }

         $imagePath = $row['image_path'] ? $row['image_path'] : 'path/to/placeholder.jpg';
           echo '<div class="product" data-name="p-' . $row['Item_ID'] . '">
                     <img src="' . $imagePath . '" alt="product image">
                     <h3>' . htmlspecialchars($row["Brand"]) . ' ' . htmlspecialchars($row["Model"]) . '</h3>
                     <div class="price">Rs.' . htmlspecialchars($row["highest_bid"]) . '</div>
                     <div class="time">' . $remainingTime . ' Left</div>
                     <div class="winner">Current Winner: ' . htmlspecialchars($row["username"] ?: "None") . '</div>
                 </div>';
       }
   } else {
       echo '<p>No products found.</p>';
   }

   // Close the database connection
   $conn->close();
   ?>

   </div>
</div>

<div class="products-preview">
   <?php
   // Reopen the connection to fetch data for previews
   $conn = new mysqli('localhost', 'root', '', 'auctionsystem');

   // Check connection
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }

   // Fetch data again for previews
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
       while ($row = $result->fetch_assoc()) {
        $imagePath = $row['image_path'] ? $row['image_path'] : 'path/to/placeholder.jpg';
           echo '<div class="preview" data-target="p-' . $row['Item_ID'] . '">
                     <i class="fas fa-times"></i>
                     <img src="' . $imagePath . '" alt="product image">
                     <h3>' . htmlspecialchars($row["Brand"]) . ' ' . htmlspecialchars($row["Model"]) . '</h3>
                     <p>' . htmlspecialchars($row["Description"]) . '</p>
                     <div class="price">Rs.' . htmlspecialchars($row["highest_bid"]) . '</div>
                     <div class="winner">Current Winner: ' . htmlspecialchars($row["username"] ?: "None") . '</div>
                     <form action="" method="POST" class="bid-form">
                        <input type="hidden" name="item_id" value="' . $row["Item_ID"] . '">
                        <input type="number" name="bid_amount" placeholder="Enter your bid" required>
                        <button type="submit" class="place-bid">Place Bid</button>
                     </form>
                 </div>';
       }
   } else {
       echo '<p>No products found.</p>';
   }

   // Close the database connection
   $conn->close();
   ?>
</div>

<script>
let preveiwContainer = document.querySelector('.products-preview');
let previewBox = preveiwContainer.querySelectorAll('.preview');

document.querySelectorAll('.products-container .product').forEach(product => {
    product.onclick = () => {
        preveiwContainer.style.display = 'flex';
        let name = product.getAttribute('data-name');
        previewBox.forEach(preview => {
            let target = preview.getAttribute('data-target');
            if (name == target) {
                preview.classList.add('active');
            }
        });
    };
});

previewBox.forEach(close => {
    close.querySelector('.fa-times').onclick = () => {
        close.classList.remove('active');
        preveiwContainer.style.display = 'none';
    };
});
</script>
</body>
</html>
