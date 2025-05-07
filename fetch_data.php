<?php
require_once "config.php";

// Query to get owner-level detail
$sql_query = "SELECT r.id, r.dOwner, t.dTown, r.dOwned, r.dVacc
              FROM tblreg r
              LEFT JOIN towns t ON r.dTownID = t.id";

if ($result = $conn->query($sql_query)) {
    while ($row = $result->fetch_assoc()) {
        $ownerName = htmlspecialchars($row['dOwner']);
        $barangay = htmlspecialchars($row['dTown']);
        $dogCount = (int)$row['dOwned'];
        $vaccinatedCount = (int)$row['dVacc'];
        $recordId = $row['id'];

        echo "<tr>
                <td>{$ownerName}</td>
                <td>{$barangay}</td>
                <td>{$dogCount}</td>
                <td>{$vaccinatedCount}</td>
                <td><a href='editdata.html?id={$recordId}' class='btn btn-warning btn-sm'>Edit</a></td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No records found. Error: " . htmlspecialchars($conn->error) . "</td></tr>";
}
?>
