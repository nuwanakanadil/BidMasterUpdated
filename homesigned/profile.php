<?php
session_start();
$username = $_SESSION['username'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'auctionsystem');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to select user details
$SQL = "SELECT F_Name, L_Name, Username, Email, Address, NIC, Phone_No FROM registeredbidder WHERE Username = '$username'";
$result = $conn->query($SQL);

if ($result === false) {
    die("SQL Error: " . $conn->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>
    <style>
        body {
            background-color: #5a6268;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        .logo {
            justify-content: center;
            text-align: center;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 400px;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-family: Arial, sans-serif;
            margin: 0 auto;
            margin-top: 60px;
            background-color: #e7ecf3;
            font-size: 15px;
        }
        .row {
            margin-bottom: 65px;
        }
        .update {
            background-color: #007bff;
            color: white;
            padding: 10px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            justify-content: center;
        }
        .update:hover {
            background-color: #0056b3;
        }
        .head-logo {
            width: 65px;
            height: 65px;
            border-radius: 5px;
        }
    </style>
    
    <body>
        <div class="logo">
            <img src="../logo.jpg" alt="Logo" class="head-logo">
        </div>
        <h1>ACCOUNT DETAILS</h1>
        <div class="container">
            <div class="row"><b>FIRST NAME: </b><?php echo htmlspecialchars($row["F_Name"]); ?></div>
            <div class="row"><b>LAST NAME: </b><?php echo htmlspecialchars($row["L_Name"]); ?></div>
            <div class="row"><b>USERNAME: </b><?php echo htmlspecialchars($row["Username"]); ?></div>
            <div class="row"><b>EMAIL: </b><?php echo htmlspecialchars($row["Email"]); ?></div>
            <div class="row"><b>ADDRESS: </b><?php echo htmlspecialchars($row["Address"]); ?></div>
            <div class="row"><b>NIC: </b><?php echo htmlspecialchars($row["NIC"]); ?></div>
            <div class="row"><b>PHONE NUMBER: </b><?php echo htmlspecialchars($row["Phone_No"]); ?></div>
            <br>
            <a href="../homesigned/home.php">Back</a>
        </div>
    </body>
    <?php
}

// Fetch won bids
?>
<div class="content">
   <h3 class="title">Your Won Bids</h3>
   <div class="products-container">
   <?php
   // Fetch data from the won_bid table
   $sql = "SELECT Item_ID, price, username, image_path FROM won_bid WHERE username = '$username'";
   
   $result = $conn->query($sql);

   if ($result && $result->num_rows > 0) {
       while ($row = $result->fetch_assoc()) {
          $imagePath = $row['image_path'] ? $row['image_path'] : 'path/to/placeholder.jpg';
          echo '<div class="product" data-name="p-' . htmlspecialchars($row['Item_ID']) . '">
                     <img src="' . htmlspecialchars($imagePath) . '" alt="product image">
                     <div class="product-details">
                         <div class="price">Rs.' . htmlspecialchars($row["price"]) . '</div>
                         <a href = "<button type="submit" class="pay-now">Pay Now</button>
                     </div>
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

<style>
   /* Style for the product container */
   .products-container {
       display: flex;
       flex-wrap: wrap;
       justify-content: center;
       gap: 20px;
       margin-top: 20px;
   }

   /* Style for individual product cards */
   .product {
       background-color: #ffffff;
       border-radius: 10px;
       box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
       overflow: hidden;
       width: 300px;
       text-align: center;
       transition: transform 0.3s;
       padding: 20px;
   }

   .product:hover {
       transform: translateY(-10px);
       box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
   }

   /* Style for the product image */
   .product img {
       width: 100%;
       height: auto;
       border-bottom: 1px solid #ddd;
       margin-bottom: 15px;
   }

   /* Style for product details (price and button) */
   .product-details {
       display: flex;
       flex-direction: column;
       align-items: center;
       justify-content: center;
   }

   .price {
       font-size: 18px;
       font-weight: bold;
       color: #333;
       margin-bottom: 10px;
   }

   /* Style for the "Pay Now" button */
   .pay-now {
       background-color: #007bff;
       color: white;
       padding: 10px 20px;
       border: none;
       border-radius: 5px;
       cursor: pointer;
       transition: background-color 0.3s;
       font-size: 16px;
   }

   .pay-now:hover {
       background-color: #0056b3;
   }

   /* Container styling */
   .content {
       padding: 20px;
       max-width: 1200px;
       margin: 0 auto;
   }

   /* Title styling */
   .title {
       text-align: center;
       font-size: 24px;
       margin-bottom: 20px;
       color: #333;
   }
</style>



<?php
?>
