<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Stationery</title> <!-- Updated title -->
</head>
<body>
    <!-- display stationery title -->
    <?php
        // Check if stationery ID is set for editing
        if (isset($_GET['editStationery'])) { // Updated to editStationery
            $edit_stationery = $_GET['editStationery']; // Updated variable name
            
            // Fetch the current stationery details
            $get_stationery = "SELECT * FROM `stationery` WHERE stationery_id = $edit_stationery"; // Updated table name
            $result = mysqli_query($conn, $get_stationery);
            $row = mysqli_fetch_assoc($result);
            $stationery_title = $row['stationery_title']; // Updated variable name
        }

        // Handle the form submission
        if (isset($_POST['update_stationery'])) { // Updated to update_stationery
            $new_stationery_title = mysqli_real_escape_string($conn, $_POST['stationery_title']); // Updated variable name
            $update_query = "UPDATE `stationery` SET stationery_title = '$new_stationery_title' WHERE stationery_id = $edit_stationery"; // Updated table name

            if (mysqli_query($conn, $update_query)) {
                echo "<script>alert('Stationery title updated successfully!');</script>"; // Updated alert
                echo "<script>window.open('adminPanel.php?viewStationery', '_self');</script>"; // Updated redirect
            } else {
                echo "<script>alert('Error updating stationery title.');</script>"; // Updated alert
            }
        }
    ?>
    <div class="container mt-3">
        <h1 class="text-center mb-4" style="overflow:hidden">Edit Stationery</h1> <!-- Updated heading -->
        <form action="" method="post" class="text-center">
            <div class="form-outline text-center w-50 m-auto">
                <label for="stationery_title" class="form-label">Stationery Title</label> <!-- Updated label -->
                <input type="text" name="stationery_title" id="stationery_title" class="form-control mb-4" value="<?php echo $stationery_title; ?>" required="required"> <!-- Updated variable name -->
            </div>
            <input type="submit" name="update_stationery" value="Update Stationery" class="btn btn-info px-3 mb-3"> <!-- Updated button text -->
        </form>
    </div>
</body>
</html>
