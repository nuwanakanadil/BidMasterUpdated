<?php
if (isset($_POST['searchQuery'])) {
    $searchQuery = $_POST['searchQuery'];
    $conn = new mysqli('localhost', 'root', '', 'auctionsystem');
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT Bidder_Id, F_Name, L_Name, Username, Position, Email, Address, NIC, Phone_No 
            FROM registeredbidder 
            WHERE Bidder_Id LIKE ? OR Username LIKE ? OR Position LIKE ?";
    
    $searchQuery = "%$searchQuery%";  // Use wildcard for partial matching
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $searchQuery, $searchQuery, $searchQuery);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
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
        echo "<tr><td colspan='9'>No users found</td></tr>";
    }

    $stmt->close();
    $conn->close();
}

?>