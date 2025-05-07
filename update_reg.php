<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $firstName = trim($_POST['firstName']);
    $middleInitial = trim($_POST['middleInitial']);
    $lastName = trim($_POST['lastName']);
    $dogsOwned = intval($_POST['dogsOwned']);
    $dogsVaccinated = intval($_POST['dogsVaccinated']);
    $townID = intval($_POST['townID']);

    // Combine full name
    if (!empty($middleInitial)) {
        $fullName = "$firstName $middleInitial $lastName";
    } else {
        $fullName = "$firstName $lastName";
    }

    // Update the record
    $stmt = $conn->prepare("UPDATE tblreg SET dOwner=?, dOwned=?, dVacc=?, dTownID=? WHERE id=?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("siiii", $fullName, $dogsOwned, $dogsVaccinated, $townID, $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Record updated successfully'); window.location.href='table.php';</script>";
    } else {
        echo "Update failed: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
