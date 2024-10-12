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

// Check if delete button is pressed and delete the record
if (isset($_POST['delete'])) {
    $id = $_POST['id'];  // Use the unique ID for deletion

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM feedback WHERE id = ?");
    $stmt->bind_param("i", $id);  // 'i' specifies integer type

    if ($stmt->execute()) {
        echo "<script>alert('Record deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting record: " . $stmt->error . "');</script>";
    }

    // Close the statement
    $stmt->close();
}

// Fetch all records from the feedback table
$sql = "SELECT * FROM feedback";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Feedback Table</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        </style>
        <style>
            body {
                margin: 0;
                padding: 0;
            }
            table {
                width: 100%;
                height: auto;
                align-items: center;
                justify-content: center;
                background-color: #fff5;
                backdrop-filter: blur(7px);
                box-shadow: 0 .4rem .8rem #0005;
                border-radius: .8rem;
                overflow: hidden;
                padding-left: 40px;
                padding-right: 30px;
            }
            table, th, td {
                border: 1px solid black;
            }
            th, td {
                padding: 10px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            .delete-btn {
                width: 75px;
                height: 30px;
                border: none;
                outline: none;
                border-radius: 6px;
                box-shadow: 0 0 10px rgba(0, 0, 0, .1);
                cursor: pointer;
                font-size: 15px;
                font-weight: 600;
            }
            .delete-btn:hover {
                color: white;
                background-color: maroon;
            }
            table, th, td {
                padding: 1rem;
                border-collapse: collapse;
            }

            .table-header {
                width: 85vw;
                height: 10%;
                background-color: #fff4;
                padding: .8rem 1rem;
                margin-left: -40px;
                padding-right: 30px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                
            }

            .table-body {
                width: 95%;
                max-height: calc(89% - 1.6rem);
                background-color: #fffb;
                margin: .8rem auto;
                border-radius: .6rem;
                overflow: auto;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .table-body::-webkit-scrollbar {
                width: 0.5rem;
                height: 0.5rem;
            }

            .table-body::-webkit-scrollbar-thumb {
                border-radius: .5rem;
                background-color: #0004;
                visibility: hidden;
            }

            .table-body:hover::-webkit-scrollbar-thumb {
                visibility: visible;
            }

            table {
                width: 100%;
            }

            thead th {
                position: sticky;
                top: 0;
                left: 0;
                padding-right: 175px;
                background: #d5d1de;
                text-align: cenetr;
            }



            tbody tr:nth-child(even) {
                background-color: #0000000b;
            }

            tbody tr td:last-child {
                text-align: center;
            }


            tbody tr:hover {
                background-color: #fff6;
            }

            .table-header .input-group ion-icon{
                width: 1.2rem;
                height: 1.2rem;
            }

            .table-header .input-group {
                height: 60%;
                background-color: #fff5;
                padding: 0 .8rem;
                border-radius: 2rem;

                display: flex;
                justify-content: center;
                align-items: center;

                transition: .2s;
            }

            .table-header .input-group:hover {
                width: 25%;
                background-color: #fff8;
                box-shadow: 0 .1rem .4rem #0002;
            }

            .table-header .input-group input {
                width: 100%;
                padding: 0 .5rem 0 .3rem;
                background-color: transparent;
                border: none;
                outline: none;
            }

        </style>
        <link rel="stylesheet" href="dashboard.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                <a href="../bids/bids.php">
                <i class='bx bxs-box' ></i>
                 <span class="links_name">Bids</span>
                </a>
                <!-- <span class="tooltip">Dashboard</span>  -->
             </li>
             <li>
                <a href="#">
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
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>

                <?php
                // Check if there are any records
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['message'] . "</td>";
                        echo "<td>
                                <form method='POST' action=''>
                                    <input type='hidden' name='id' value='" . $row['id'] . "' />
                                    <input type='submit' name='delete' value='Delete' class='delete-btn' />
                                </form>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No feedback records found</td></tr>";
                }

                // Close the database connection
                $conn->close();
                ?>

            </table>
                </div>
            
            </div>
        </div>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>
</html>
