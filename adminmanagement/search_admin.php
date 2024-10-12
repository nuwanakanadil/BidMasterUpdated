<?php
if (isset($_POST['searchQuery'])) {
    $searchQuery = $_POST['searchQuery'];
    $conn = new mysqli('localhost', 'root', '', 'auctionsystem');
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT admin_id, first_name, last_name, username, Email, 
            FROM admin 
            WHERE admin_id LIKE ? OR username LIKE ?";
    
    $searchQuery = "%$searchQuery%";  // Use wildcard for partial matching
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $searchQuery, $searchQuery, $searchQuery);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["admin_id"] . "</td>
                    <td>" . $row["first_name"] . " " . $row["last_name"] . "</td>
                    <td>" . $row["username"] . "</td>
                    <td>" . $row["email"] . "</td>
                    <td>
                        <button onclick=\"readInfo('" . $row["first_name"] . "', '" . $row["last_name"] . "', '" . $row["username"] . "',  '" . $row["email"] . "')\"><i class='fa-regular fa-eye'></i></button>
                        <button onclick=\"editInfo('" . $row["admin_id"] . "'," . $row["first_name"] . "', '" . $row["last_name"] . "', '" . $row["username"] . "',  '" . $row["email"] . "')\"><i class='fa-regular fa-pen-to-square'></i></button>
                        <button onclick=\"deleteUser(" . $row["admin_id"] . ")\"><i class='fa-regular fa-trash-can'></i></button>
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