<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canine Data</title>
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- JavaScript Bundle with Popper -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="js/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="js/jquery.dataTables.min.js"></script>
    
    <style>
        /* Highlight row on hover */
        .table tbody tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        /* Highlight selected row */
        .selected-row {
            background-color: #d4edda !important; /* Light green */
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize DataTables
            $('.table').DataTable({
                "paging": true,        
                "ordering": true,      
                "info": true           
            });

            // Row Click Highlighting
            $(".table tbody").on("click", "tr", function() {
                $(".table tbody tr").removeClass("selected-row"); // Remove previous selection
                $(this).addClass("selected-row"); // Add class to clicked row
            });
        });
    </script>
</head>

<body>
<section class="my-5">
    <div class="container">
        <h2 class="text-center mb-4">Registered Canines</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Dogs Owned</th>
                        <th scope="col">Dogs Vaccinated</th>
                        <th scope="col">Owner Name</th>
                        <th scope="col">Registration Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    require_once "config.php";
                    // SQL query to get the number of dogs owned and vaccinated per owner
                    $sql_query = "SELECT 
                                    dOwner, 
                                    SUM(dOwned) AS total_dogs_owned, 
                                    SUM(dVacc) AS total_dogs_vaccinated, 
                                    dRegistrationDate 
                                  FROM tblreg
                                  GROUP BY dOwner, dRegistrationDate";

                    // Execute the query and fetch results
                    if ($result = $conn->query($sql_query)) {
                        while ($row = $result->fetch_assoc()) { 
                            // Get the number of dogs owned and vaccinated
                            $TotalDogsOwned = htmlspecialchars($row['total_dogs_owned'] ?? 0);
                            $TotalDogsVaccinated = htmlspecialchars($row['total_dogs_vaccinated'] ?? 0);
                            $Owner = htmlspecialchars($row['dOwner'] ?? 'Unknown');
                            $RegistrationDate = htmlspecialchars($row['dRegistrationDate'] ?? 'N/A');
                    ?>
                    <tr>
                        <!-- Display the count of dogs owned and vaccinated -->
                        <td><?php echo $TotalDogsOwned; ?></td>
                        <td><?php echo $TotalDogsVaccinated; ?></td>
                        <td><?php echo $Owner; ?></td>
                        <td><?php echo $RegistrationDate; ?></td>
                    </tr>
                    <?php
                        } 
                    } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Button to go back to home -->
<div class="text-center my-4">
    <button class="btn btn-primary" onclick="window.location.href='user_d.html'">Go to Home</button>
</div>

</body>  
</html>
