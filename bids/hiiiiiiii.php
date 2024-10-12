<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bids Management</title>
    <link rel="stylesheet" href="bids.css">
</head>
<body>

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
                        <th>Images</th>
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
                $sql = "SELECT Item_ID, Conditions, Brand, Model, Price, Description, Images FROM seller_item";
                $result = $conn->query($sql);

                // Check if the query was successful
                if ($result === false) {
                    // Output the error
                    echo "Error: " . $conn->error;
                } else {
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["Item_ID"] . "</td>
                                    <td>" . $row["Conditions"] . "</td>
                                    <td>" . $row["Brand"] . "</td>
                                    <td>" . $row["Model"] . "</td>
                                    <td>" . $row["Price"] . "</td>
                                    <td>" . $row["Description"] . "</td>
                                    <td>" . $row["Images"] . "</td>
                                    <td>
                                        <button class='updateBtn'>Accept</button>
                                        <button class='removeBtn'>Decline</button>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No items found</td></tr>";
                    }
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
                </div>
                <div class="input-field">
                    <input type="text" id="deleteId" placeholder="Enter Bid ID">
                    <button class="removeBtn" onclick="deleteById()">Delete</button>
                </div>
                <div id="result"></div>
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
                        <th>Started Price</th>
                        <th>Ongoing Price</th>
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
                    $sql = "SELECT bid_id, Item_ID, started_price, ongoing_price, highest_bid, started_date, ending_date FROM bids";
                    $result = $conn->query($sql);
            
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["bid_id"] . "</td>
                                    <td>" . $row["Item_ID"] . "</td>
                                    <td>" . $row["started_price"] . "</td>
                                    <td>" . $row["ongoing_price"] . "</td>
                                    <td>" . $row["highest_bid"] . "</td>
                                    <td>" . $row["started_date"] . "</td>
                                    <td>" . $row["ending_date"] . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No users found</td></tr>";
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
