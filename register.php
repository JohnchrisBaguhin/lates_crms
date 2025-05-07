<?php
// Include the database configuration file to establish a connection
include('config.php');

// Check if the request method is POST (form submission)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve data from the form
    $dogsOwned = $_POST['dogsOwned'];
    $dogsVaccinated = $_POST['dogsVaccinated'];
    $dFirstName = $_POST['firstName'];
    $dMiddleInitial = $_POST['middleInitial'];  // Middle name/initial (optional)
    $dLastName = $_POST['lastName'];
    $dTownID = $_POST['townID'];  // get selected town ID


    // Full owner name can be combined for storage or further use
    if (!empty($dMiddleInitial)) {
        $dOwnerFullName = $dFirstName . ' ' . $dMiddleInitial . ' ' . $dLastName;
    } else {
        $dOwnerFullName = $dFirstName . ' ' . $dLastName;
    }

    // Debugging: Check the full name before inserting
    echo "Owner Full Name: " . $dOwnerFullName; // Check if it's correct

    // Get the current date in 'YYYY-MM-DD' format
    $currentDate = date('Y-m-d');  // Current date (e.g., 2025-03-18)

    // Prepare the SQL query to insert the data into the database
    $stmt = $conn->prepare("INSERT INTO tblreg (dOwner, dOwned, dVacc, dTownID, dRegistrationDate) VALUES (?, ?, ?, ?, ?)");
    
    // Check if the prepared statement was successful
    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        exit;
    }

    // Bind parameters to the query
    $stmt->bind_param("siiis", $dOwnerFullName, $dogsOwned, $dogsVaccinated, $dTownID, $currentDate); 

    // Execute the query
    if ($stmt->execute()) {
        // If the insertion is successful, return a success message
        echo "Registration successful!";
    } else {
        // If there is an error, output the error
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement and the database connection
    $stmt->close();
    $conn->close();
} else {
    // If the request is not POST, return an error message
    echo "Invalid request method.";
}
?>
