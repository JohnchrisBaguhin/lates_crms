<?php
include('config.php');

$result = $conn->query("SELECT id, dTown FROM towns");
$towns = [];

while ($row = $result->fetch_assoc()) {
    $towns[] = ['id' => $row['id'], 'name' => $row['dTown']];
}

echo json_encode($towns);
