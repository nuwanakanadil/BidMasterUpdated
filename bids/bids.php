<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'auctionsystem');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get current date and time
$currentDateTime = date('Y-m-d H:i:s');

// Query to find expired bids (where ending_date is earlier than now)
$sql = "SELECT b.Item_ID, b.highest_bid, b.username, bi.image_path
        FROM bids b
        LEFT JOIN bid_items bi ON b.Item_ID = bi.Item_ID
        WHERE ending_date < ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $currentDateTime);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Loop through each expired bid and add it to won_bid table, then delete from bids and bid_items tables
    while ($row = $result->fetch_assoc()) {
        $itemId = $row['Item_ID'];
        $highestBid = $row['highest_bid'];
        $username = $row['username'];
        $image_path = $row['image_path'];

        // Insert into won_bid table
        $insertWonBidSql = "INSERT INTO won_bid (Item_ID, Price, username, image_path) VALUES (?, ?, ?, ?)";
        $insertWonBidStmt = $conn->prepare($insertWonBidSql);
        $insertWonBidStmt->bind_param('iiss', $itemId, $highestBid, $username, $image_path);
        $insertWonBidStmt->execute();

        // Delete from bids table using Item_ID
        $deleteBidSql = "DELETE FROM bids WHERE Item_ID = ?";
        $deleteBidStmt = $conn->prepare($deleteBidSql);
        $deleteBidStmt->bind_param('i', $itemId);
        $deleteBidStmt->execute();

        // Delete from bid_items table using Item_ID
        $deleteItemSql = "DELETE FROM bid_items WHERE Item_ID = ?";
        $deleteItemStmt = $conn->prepare($deleteItemSql);
        $deleteItemStmt->bind_param('i', $itemId);
        $deleteItemStmt->execute();
    }
}

// Close the connection
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bids Management</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="bids.css">
    <script src="bids.js"></script>
</head>
<body>

<div class="sidebar">
    <div class="logo_content">
        <div class="logo">
            <i></i>
            <div class="logo_name">BidMaster</div>
        </div>
    </div>
    <ul class="nav_list">
    <li>
               <a href="../admindashboard/dashboard.php">
                <i class='bx bx-grid-alt'></i>
                <span class="links_name">Dashboard</span>
               </a>
               <!-- <span class="tooltip">Dashboard</span>  -->
            </li>
            <li>
                <a href="../adminmanagement/admin_management.php">
                <i class='bx bx-shield-quarter'></i>
                 <span class="links_name">Admins</span>
                </a>
                <!-- <span class="tooltip">Dashboard</span>  -->
             </li>
            <li>
                <a href="../usermanagement/user_management.php">
                    <i class='bx bxs-user' ></i>
                 <span class="links_name">Users</span>
                </a>
                <!-- <span class="tooltip">Dashboard</span>  -->
             </li>
             <li>
                <a href="#">
                <i class='bx bxs-box' ></i>
                 <span class="links_name">Bids</span>
                </a>
                <!-- <span class="tooltip">Dashboard</span>  -->
             </li>
             <li>
                <a href="../Feedback/Admin-feedback-pannel.php">
                <i class='bx bxs-message-dots' ></i>
                 <span class="links_name">Feedback</span>
                </a>
                <!-- <span class="tooltip">Dashboard</span>  -->
             </li>
    </ul>
    <div class="profile_content">
        <div class="profile">
            <div class="profile_details">
            <a href="../homesigned/profile.php"><img src="icon-5359553_640.webp" alt="" id="profile_view"></a>
                    <div class="name_job">
                        <div class="name">Admin</div>
                        <div class="job">System Administrator</div>
                    </div>
                </div>
                <a href="../homesigned/home.php"><i class='bx bx-log-out' id="log_out"></i></a>
        </div>
    </div>
</div>

<!--approve bids-->
<main class="table">
    <section class="table-header">
        <h1>Items To Be Accepted</h1>
    </section>
    <section class="table-body">
        <table>
            <thead>
                <tr>
                    <th>Item ID</th>
                    <th>Condition</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="eventsTableBody2">
            <?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'auctionsystem');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch current data from seller_item table
$sql = "SELECT si.Item_ID, si.Conditions, si.Brand, si.Model, si.Price, si.Description, ii.image_path 
        FROM seller_item si 
        LEFT JOIN item_images ii ON si.Item_ID = ii.Item_ID";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imagePath = $row['image_path'] ? $row['image_path'] : 'path/to/placeholder.jpg';
        echo "<tr>
                <td>" . htmlspecialchars($row["Item_ID"]) . "</td>
                <td>" . htmlspecialchars($row["Conditions"]) . "</td>
                <td>" . htmlspecialchars($row["Brand"]) . "</td>
                <td>" . htmlspecialchars($row["Model"]) . "</td>
                <td>" . htmlspecialchars($row["Price"]) . "</td>
                <td>" . htmlspecialchars($row["Description"]) . "</td>
                <td><img src='$imagePath' alt='Image' style='max-width: 100px; max-height: 100px;'></td>
                <td>
                    <button class='updateBtn' data-id='" . htmlspecialchars($row["Item_ID"]) . "' onclick='acceptItem(this)'>Accept</button>
                    <button class='removeBtn' data-id='" . htmlspecialchars($row["Item_ID"]) . "' onclick='declineItem(this)'>Decline</button>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='8'>No items found</td></tr>";
}

$conn->close();
?>
</tbody>

        </table>
    </section>

    <div class="input-box">
        <div class="input-field">
            <input type="text" id="searchId2" placeholder="Enter Item ID">
            <button class="updateBtn" onclick="searchItemsById()">Search</button>
            <button class="reloadBtn" onclick="resetTable()">Reset</button>
        </div>
    </div>
</main>

<!-- Ongoing Bid List Section -->
<main class="table">
    <section class="table-header">
        <h1>Ongoing Bid List</h1>
    </section>
    <section class="table-body">
        <table>
            <thead>
                <tr>
                    <th>Bid ID</th>
                    <th>Item ID</th>
                    <th>Started Bid</th>
                    <th>Highest Bid</th>
                    <th>Started Date</th>
                    <th>Ending Date</th>
                </tr>
            </thead>
            <tbody id="eventsTableBody">
                <?php
                // Database connection
                $conn = new mysqli('localhost', 'root', '', 'auctionsystem');
                
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch data from database
                $sql = "SELECT bid_id, Item_ID, started_bid, highest_bid, started_date, ending_date FROM bids
                WHERE ending_date >= NOW()";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row["bid_id"]) . "</td>
                                <td>" . htmlspecialchars($row["Item_ID"]) . "</td>
                                <td>" . htmlspecialchars($row["started_bid"]) . "</td>
                                <td>" . htmlspecialchars($row["highest_bid"]) . "</td>
                                <td>" . htmlspecialchars($row["started_date"]) . "</td>
                                <td>" . htmlspecialchars($row["ending_date"]) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No bids found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </section>

    <div class="input-box">
        <div class="input-field">
            <input type="text" id="searchId" placeholder="Enter Bid ID">
            <button class="updateBtn" onclick="searchById()">Search</button>
            <button class="reloadBtn" onclick="resetTable()">Reset</button>
        </div>
        <div class="input-field">
            <input type="text" id="deleteId" placeholder="Enter Bid ID">
            <button class="removeBtn" onclick="deleteById()">Delete</button>
        </div>
        <div id="result"></div>
    </div>
</main>

</body>
</html>
