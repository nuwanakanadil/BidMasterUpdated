<?php

session_start();

$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>User Management</title>
    <link rel="stylesheet" href="user_management.css">
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
                <a href="../admin_dashboard/dashboard.php">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="../adminmanagement/admin_management.php">
                <i class='bx bx-shield-quarter'></i>
                 <span class="links_name">Admins</span>
                </a>
                <!-- <span class="tooltip">Dashboard</span>  -->
             </li>
            <li>
                <a href="#">
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

    <div class="container">

        <header>

            <div class="filterEntries">

                <div class="filter">
                    <label for="search">Search:</label>
                    <input type="search" name="" id="search" placeholder="Enter id/username/position">
                    <div class="searchBtn">
                        <button onclick="searchUser()">Search</button>
                    </div>
                </div>

            </div>

            <div class="addMemberBtn">
                <button onclick="openPopup()">New member</button>
            </div>

        </header>

        <table>
            <thead>
                <tr class="heading">
                    <th>User ID</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Position</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>NIC</th>
                    <th>Phone_No</th>
                    <th>Action</th>
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
                $sql = "SELECT Bidder_Id, F_Name, L_Name, Username, Position, Email, Address, NIC, Phone_No FROM registeredbidder";
                $result = $conn->query($sql);
        
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["Bidder_Id"] . "</td>
                                <td>" . $row["F_Name"] . " " . $row["L_Name"] . "</td>
                                <td>" . $row["Username"] . "</td>
                                <td>" . $row["Position"] . "</td>
                                <td>" . $row["Email"] . "</td>
                                <td>" . $row["Address"] . "</td>
                                <td>" . $row["NIC"] . "</td>
                                <td>" . $row["Phone_No"] . "</td>
                                <td>
                                    <button onclick=\"readInfo('" . $row["F_Name"] . "', '" . $row["L_Name"] . "', '" . $row["Username"] . "', '" . $row["Position"] . "', '" . $row["Email"] . "', '" . $row["Address"] . "', '" . $row["NIC"] . "', '" . $row["Phone_No"] . "')\"><i class='fa-regular fa-eye'></i></button>
                                    <button onclick=\"editInfo(" . $row["Bidder_Id"] . ", '" . $row["F_Name"] . "', '" . $row["L_Name"] . "', '" . $row["Username"] . "', '" . $row["Position"] . "', '" . $row["Email"] . "', '" . $row["Address"] . "', '" . $row["NIC"] . "', '" . $row["Phone_No"] . "')\"><i class='fa-regular fa-pen-to-square'></i></button>
                                    <button onclick=\"deleteUser(" . $row["Bidder_Id"] . ")\"><i class='fa-regular fa-trash-can'></i></button>
                                </td>
                            </tr>";

                    }
                } else {
                    echo "<tr><td colspan='10'>No users found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>

        </table>
        
    </div>

    <!-- Popup Form -->
    <div class="dark_bg" id="dark_bg">

        <div class="popup" id="popup_form">
            <header>
                <h2 class="modalTitle">Fill the Form</h2>
                <button class="closeBtn" onclick="closePopup()">&times;</button>
            </header>

            <div class="body">
                <form action="submit_user.php" method="post" id="myForm">
                    <div class="inputFieldContainer">

                        <div class="nameField">
                            <div class="form_control">
                                <label for="fName">First Name:</label>
                                <input type="text" id="fName" name="fName" required>
                            </div>

                            <div class="form_control">
                                <label for="lName">Last Name:</label>
                                <input type="text" id="lName" name="lName" required>
                            </div>
                        </div>

                        <div class="nameField">
                            <div class="form_control">
                                <label for="fName">Username:</label>
                                <input type="text" id="uName" name="uName" required>
                            </div>

                            <div class="form_control">
                                <label for="position">Position:</label>
                                <input type="text" id="position" name="position" required>
                            </div>

                        </div>

                            <div class="form_control">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                        

                        
                            <div class="form_control">
                                <label for="address">Address:</label>
                                <input type="text" id="address" name="address" required>
                            </div>
                        
                        <div class="nameField">   
                            <div class="form_control">
                                <label for="nic">NIC:</label>
                                <input type="text" id="nic" name="nic" required>
                            </div>
                            <div class="form_control">
                                <label for="phone">Phone:</label>
                                <input type="number" id="phone" name="phone" required>
                            </div>
                        </div>

                      
                        

                         <!-- Hidden fields for userId and rowIndex -->
                        <input type="hidden" id="userId" name="userId">

                    </div>
            </div>

            <footer class="popupFooter">
                <button type="submit" class="submitBtn">Submit</button>
            </footer>
        </form>

        </div>

    </div>

    <script src="user_management.js"></script>
</body>

</html>
