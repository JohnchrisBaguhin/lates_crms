<?php
include('config.php');

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'No ID provided']);
    exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM tblreg WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo json_encode(['error' => 'Record not found']);
    exit;
}

$row = $result->fetch_assoc();
$nameParts = explode(' ', $row['dOwner']);
$response = [
    'id' => $row['id'],
    'firstName' => $nameParts[0] ?? '',
    'middleInitial' => $nameParts[1] ?? '',
    'lastName' => $nameParts[2] ?? '',
    'dogsOwned' => $row['dOwned'],
    'dogsVaccinated' => $row['dVacc'],
    'townID' => $row['dTownID'],
];

echo json_encode($response);
