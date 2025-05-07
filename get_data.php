<?php
require 'config.php';

// Join towns and tblreg
$sql = "
    SELECT 
        towns.dTown, 
        towns.dLatitude, 
        towns.dLongitude,
        SUM(tblreg.dOwned) AS totalOwned,
        SUM(tblreg.dVacc) AS totalVaccinated
    FROM tblreg
    LEFT JOIN towns ON tblreg.dTownID = towns.id
    GROUP BY tblreg.dTownID
";

$result = $conn->query($sql);

$zones = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $zones[] = [
            'dTown' => $row['dTown'] ?? 'Unknown',
            'dLatitude' => $row['dLatitude'] ?? 9.5984, // fallback center if missing
            'dLongitude' => $row['dLongitude'] ?? 124.0937,
            'dog_count' => (int) $row['totalOwned'],
            'vaccinated_count' => (int) $row['totalVaccinated']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($zones);
?>
