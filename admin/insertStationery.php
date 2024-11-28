<?php
include('../database/connection.php');

$alertMessage = ''; // Initialize alert message

if (isset($_POST['insert_stationery'])) {
    $stationery_title = $_POST['stationery_title'];

    // Select data from database to check if stationery already exists
    $select_query = "SELECT * FROM `stationery` WHERE stationery_title = '$stationery_title'";
    $result_select = mysqli_query($conn, $select_query);
    $number = mysqli_num_rows($result_select);

    if ($number > 0) {
        $alertMessage = '<div class="p1 alert alert-danger alert-dismissible fade show" role="alert">
                            This stationery is already present in the database.
                            <button type="button" class="p1 close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
    } else {
        // Insert stationery into database
        $insert_query = "INSERT INTO `stationery` (stationery_title) VALUES ('$stationery_title')";
        $result = mysqli_query($conn, $insert_query);
        
        if ($result) {
            $alertMessage = '<div class="p1 alert alert-success alert-dismissible fade show" role="alert">
                                Stationery has been inserted successfully!
                                <button type="button" class="p1 close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
        } else {
            $alertMessage = '<div class="p1 alert alert-danger alert-dismissible fade show" role="alert">
                                Failed to insert stationery.
                                <button type="button" class="p1 close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
            // Optionally, you can also output the MySQL error for debugging
            echo mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Stationaries</title>
    <!-- Bootstrap CSS link-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
    <!-- Custom JS to slide up the alert -->
    <script>
        $(document).ready(function() {
            // Slide up alert after 3 seconds
            setTimeout(function() {
                $(".alert").slideUp(500);
            }, 3000); // 3000ms = 3 seconds
        });
    </script>
</head>
<style>
    .alert {
            text-align: center;
        }
</style>
<body class="p1 bg-light">
    <div class="p1 container mt-4">
        <!-- Display alert message if any -->
            <?php echo $alertMessage; ?>

        <h4 class="p1 text-center " style="overflow:hidden;">Insert Stationeries</h4>
        <!-- Form -->
        <form action="" method="post" class="p1 mb-4">
            <div class="p1 input-group w-50 m-auto mb-2">
                <input type="text" class="p1 form-control" name="stationery_title" placeholder="Insert stationery" aria-label="stationery" aria-describedby="basic-addon1" required>
            </div>

            <div class="p1 input-group w-50 m-auto mb-2">
                <input type="submit" class="p1 btn btn-style mt-3" name="insert_stationery" value="Insert stationery">
            </div>
        </form>
    </div>
</body>
</html>
