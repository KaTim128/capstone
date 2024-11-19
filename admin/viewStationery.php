<?php
include('../database/connection.php');

// Initialize alert message variable
$alertMessage = '';

// Check if a deletion has been triggered
if (isset($_GET['deleteStationery'])) {
    $stationery_id_to_delete = $_GET['deleteStationery'];

    // Attempt to delete the selected stationery
    $delete_query = "DELETE FROM `stationery` WHERE stationery_id = $stationery_id_to_delete";
    if (mysqli_query($conn, $delete_query)) {
        // Store success message in session
        $_SESSION['alertMessage'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Success!</strong> Stationery deleted successfully!
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
    } else {
        // Store error message in session
        $_SESSION['alertMessage'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong> There was an issue deleting the stationery.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
    }

    // Redirect to the same page to avoid re-triggering the delete on page reload
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Check if an alert message is set in the session
if (isset($_SESSION['alertMessage'])) {
    $alertMessage = $_SESSION['alertMessage'];
    // Clear the alert message from the session after displaying it
    unset($_SESSION['alertMessage']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Stationery</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        h3 {
            overflow: hidden;
        }

        td {
            word-wrap: break-word;
            max-width: 150px;
        }

        th, td {
            width: 150px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Display alert message if any -->
        <div id="alertContainer">
            <?php echo $alertMessage; ?>
        </div>

        <h4 class="text-center text-success" style="overflow:hidden;">All Stationeries</h4>
        <table class="table table-bordered mt-3">
            <thead class="table-color">
                <tr class="text-center table-color text-dark">
                    <th>S.No</th>
                    <th>Stationery Title</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody class="bg-secondary text-light">
                <?php
                    $select_stationery = "SELECT * FROM `stationery`";
                    $result = mysqli_query($conn, $select_stationery);
                    $row_count = mysqli_num_rows($result); // Get row count
                    $number = 0;

                    if ($row_count == 0) {
                        echo "<div class='alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>There are no stationeries yet.</div>";
                    } else {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $stationery_id = $row['stationery_id'];
                            $stationery_title = $row['stationery_title'];
                            $number++;
                ?>
                <tr class="text-center">
                    <td><?php echo $number; ?></td>
                    <td><?php echo $stationery_title; ?></td>
                    <td><a href='adminPanel.php?editStationery=<?php echo $stationery_id; ?>' class='text-light'><i class='fa-solid fa-pen-to-square'></i></a></td>
                    <td><a href="#" class="text-light" data-toggle="modal" data-target="#deleteModal" onclick="setStationeryId(<?php echo $stationery_id; ?>)"><i class='fa-solid fa-trash'></i></a></td>
                </tr>
                <?php
                        }
                    }
                ?>
            </tbody>
        </table>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h6 style="overflow:hidden">Are you sure you would like to delete this Stationery?</h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Yes, Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Store stationery ID for deletion
        let stationeryId = null;

        function setStationeryId(id) {
            stationeryId = id; // Store the stationery ID when delete button is clicked
        }

        // Handle delete confirmation
        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (stationeryId) {
                // Redirect to PHP delete action with the stationery_id
                window.location.href = `adminPanel.php?deleteStationery=${stationeryId}`;
            }
        });
    </script>
</body>
</html>
