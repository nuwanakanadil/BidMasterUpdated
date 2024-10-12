<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'auctionsystem');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the total number of users
$userCountQuery = "SELECT COUNT(*) AS total_users FROM registeredbidder";
$userCountResult = $conn->query($userCountQuery);
$userCount = $userCountResult->fetch_assoc()['total_users'];

// Fetch the total number of bids
$auctionCountQuery = "SELECT COUNT(*) AS total_auctions FROM bids";
$auctionCountResult = $conn->query($auctionCountQuery);
$auctionCount = $auctionCountResult->fetch_assoc()['total_auctions'];

// Fetch the total number of items
$itemCountQuery = "SELECT COUNT(*) AS total_items FROM seller_item";
$itemCountResult = $conn->query($itemCountQuery);
$itemCount = $itemCountResult->fetch_assoc()['total_items'];

// Fetch data for recent bids
$sql = "SELECT bid_id, Item_ID, highest_bid, ending_date FROM bids";
$result = $conn->query($sql);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="dashboard.css">
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
               <a href="#">
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
                <a href="../bids/bids.php">
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
        <!--main-->
        <div class="main">
            <div class="topbar">
               
            </div>

            <!--Cards-->
            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $userCount; ?></div>
                        <div class="cardName">User Count</div>
                    </div>
                    <div class="iconBx">
                        <ion-icon name="person-outline"></ion-icon>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $auctionCount; ?></div>
                        <div class="cardName">Auctions Count</div>
                    </div>
                    <div class="iconBx">
                        <ion-icon name="albums-outline"></ion-icon>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $itemCount; ?></div>
                        <div class="cardName">Items Count (To Accept)</div>
                    </div>
                    <div class="iconBx">
                        <ion-icon name="cube-outline"></ion-icon>
                    </div>
                </div>
            </div>
            <div class="bookings">
                <div class="recentBookings">
                    <div class="cardHeader">
                        <h2>Recent Auctions</h2>
                        <a href="../bids/bids.php" class="btn">View All</a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Bid ID</td>
                                <td>Item ID</td>
                                <td>Highest Bid</td>
                                <td>Ending Date</td>
                            </tr>
                        </thead>
                        <tbody> 
                        <?php
                        if ($result->num_rows > 0) {
                            
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . $row["bid_id"] . "</td>
                                        <td>" . $row["Item_ID"] . "</td>
                                        <td>" . $row["highest_bid"] . "</td>
                                        <td>" . $row["ending_date"] . "</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No bids found</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
           
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
