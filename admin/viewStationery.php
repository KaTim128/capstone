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
<?php
    // Display an alert if no stationery is available
    $select_stationery = "SELECT * FROM `stationery`";
    $result = mysqli_query($conn, $select_stationery);
    $row_count = mysqli_num_rows($result); // Get row count
    
    if ($row_count == 0) {
        echo "<div class='alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>No stationery available.</div>";
    }
?>

<h4 class="p1 text-center text-success mt-4" style="overflow:hidden;">All Stationeries</h4>
<table class="p1 table table-bordered mt-3">
    <thead class="p1 table-color">
        <!-- Header row -->
        <tr class="text-center table-color text-dark">
            <th class="p1">S.No</th>
            <th class="p1">Stationery Title</th>
            <th class="p1">Edit</th>
            <th class="p1">Delete</th>
        </tr>
    </thead>
    <tbody class="p1 bg-secondary text-light">
        <?php
            if ($row_count == 0) {
                echo "<div class='alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>There are no stationeries yet.</div>";
            } else {
                $number = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $stationery_id = $row['stationery_id'];
                    $stationery_title = $row['stationery_title'];
                    $number++;
        ?>
            <tr class="p1 text-center">
                <td><?php echo $number; ?></td>
                <td><?php echo $stationery_title; ?></td>
                <td><a href='adminPanel.php?editStationery=<?php echo $stationery_id; ?>' class='text-light'><i class='fa-solid fa-pen-to-square'></i></a></td>
                <td><a href="#" class="p1 text-light" data-toggle="modal" data-target="#deleteModal" onclick="setStationeryId(<?php echo $stationery_id; ?>)"><i class='fa-solid fa-trash'></i></a></td>
            </tr>
        <?php
                }
            }
        ?>
    </tbody>
</table>

    <!-- Delete Confirmation Modal -->
    <div class="p1 modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="p1 modal-dialog" role="document">
            <div class="p1 modal-content">
                <div class="p1 modal-body">
                    <h6 style="overflow:hidden">Are you sure you would like to delete this Stationery?</h6>
                </div>
                <div class="p1 modal-footer">
                    <button type="button" class="p1 btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="p1 btn btn-danger" id="confirmDelete">Yes, Delete</button>
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
