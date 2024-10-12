<?php
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $conn = new mysqli('localhost', 'root', '', 'auctionsystem');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT bid_id, Item_ID, started_bid, highest_bid, started_date, ending_date FROM bids WHERE bid_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["bid_id"] . "</td>
                    <td>" . $row["Item_ID"] . "</td>
                    <td>" . $row["started_bid"] . "</td>
                    <td>" . $row["highest_bid"] . "</td>
                    <td>" . $row["started_date"] . "</td>
                    <td>" . $row["ending_date"] . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No bids found</td></tr>";
    }

    $stmt->close();
    $conn->close();
}
?>