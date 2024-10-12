<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Admin Management</title>
    <link rel="stylesheet" href="admin_management.css">
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
                <a href="#">
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
                    <img src="icon-5359553_640.webp" alt="" id="profile_view">
                    <div class="name_job">
                        <div class="name">Admin</div>
                        <div class="job">System Administrator</div>
                    </div>
                </div>
                <i class='bx bx-log-out' id="log_out"></i>
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
                <button onclick="openPopup()">New admin</button>
            </div>

        </header>

        <table>
            <thead>
                <tr class="heading">
                    <th>Admin ID</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Email</th>
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
                $sql = "SELECT admin_id, first_name, last_name, username, role, status, email FROM admin";
                $result = $conn->query($sql);
        
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["admin_id"] . "</td>
                                <td>" . $row["first_name"] . " " . $row["last_name"] . "</td>
                                <td>" . $row["username"] . "</td>
                                <td>" . $row["role"] . "</td>
                                <td>" . $row["status"] . "</td>
                                <td>" . $row["email"] . "</td>
                                
                                <td>
                                    <button onclick=\"readInfo('" . $row["first_name"] . "', '" . $row["last_name"] . "', '" . $row["username"] . "',  '" . $row["email"] . "')\"><i class='fa-regular fa-eye'></i></button>
                                    <button onclick=\"editInfo('" . $row["admin_id"] . "', '" . $row["first_name"] . "', '" . $row["last_name"] . "', '" . $row["username"] . "',  '" . $row["email"] . "')\"><i class='fa-regular fa-pen-to-square'></i></button>
                                    <button onclick=\"deleteUser(" . $row["admin_id"] . ")\"><i class='fa-regular fa-trash-can'></i></button>
                                </td>
                            </tr>";

                    }
                } else {
                    echo "<tr><td colspan='10'>No Admins found</td></tr>";
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
                <form action="submit_admin.php" method="POST" id="myForm">
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
                                <label for="uName">Username:</label>
                                <input type="text" id="uName" name="uName" required>
                            </div>
                        </div>

                            

                            <div class="form_control">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                      
                         <!-- Hidden fields for adminId -->
                        <input type="hidden" id="adminId" name="adminId">

                    </div>
            </div>

            <footer class="popupFooter">
                <button type="submit" class="submitBtn">Submit</button>
            </footer>
        </form>

        </div>

    </div>

    <script src="admin_management.js"></script>
</body>

</html>
