<?php
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $conn = new mysqli('localhost', 'root', '', 'auctionsystem');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT si.Item_ID, si.Conditions, si.Brand, si.Model, si.Price, si.Description, ii.image_path 
            FROM seller_item si 
            LEFT JOIN item_images ii ON si.Item_ID = ii.Item_ID";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $imagePath = $row['image_path']; // Use the path directly from the database

            // Check if the image file exists in the uploads folder
            if (!file_exists($imagePath)) {
                $imagePath = 'path/to/placeholder.jpg'; // Path to a placeholder image
            }

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
}
?>