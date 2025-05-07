<?php
require 'config.php';

$sql = "SELECT id, dTown FROM towns ORDER BY dTown ASC";
$result = $conn->query($sql);

$towns = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $towns[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($towns);
?>
