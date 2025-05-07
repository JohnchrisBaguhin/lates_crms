<?php
// Include the database configuration file to establish a connection
include('config.php');

// Check if the request method is POST (form submission)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve data from the form
    $dogsOwned = $_POST['dogsOwned'];           // Optional: currently not used in DB insert
    $dogsVaccinated = $_POST['dogsVaccinated'];
    $dFirstName = $_POST['firstName'];
    $dMiddleInitial = $_POST['middleInitial'];  // Middle name/initial (optional)
    $dLastName = $_POST['lastName'];
    $dTownID = $_POST['townID'];                // Selected town ID

    // Combine full name
    if (!empty($dMiddleInitial)) {
        $dOwnerFullName = $dFirstName . ' ' . $dMiddleInitial . ' ' . $dLastName;
    } else {
        $dOwnerFullName = $dFirstName . ' ' . $dLastName;
    }

    // Debugging output
    echo "Owner Full Name: " . $dOwnerFullName . "<br>";

    // Get current date in 'YYYY-MM-DD' format
    $currentDate = date('Y-m-d');

    // Prepare SQL query to insert data into the database
    $stmt = $conn->prepare("
        INSERT INTO tblreg (dOwner, dVaccinated, dTownID, dRegistrationDate)
        VALUES (?, ?, ?, ?)
    ");

    // Check if preparation was successful
    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        exit;
    }

    // Bind parameters: s = string, i = integer
    $stmt->bind_param("siis", $dOwnerFullName, $dogsVaccinated, $dTownID, $currentDate);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Clean up
    $stmt->close();
    $conn->close();

} else {
    echo "Invalid request method.";
}
?>
