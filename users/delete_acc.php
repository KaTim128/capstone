<?php
include('../database/connection.php'); // Include your database connection file

// PHP code to handle form submissions
$username_session = $_SESSION['user_username'];
if (isset($_POST['confirm_delete'])) {
    $delete_query = "DELETE FROM `user` WHERE user_username = '$username_session'";
    $result = mysqli_query($conn, $delete_query);
    if ($result) {
        session_destroy();
        echo "<script>window.open('success_del.php', '_self');</script>";
    }
}

if (isset($_POST['dont_delete'])) {
    echo "<script>window.open('profile.php', '_self');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link rel="stylesheet" href="../style.css"> <!-- Include your CSS file -->
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #e0f7fa; /* Light cyan background */
            font-family: "Fredericka the Great", "cursive";
        }
        .form-container {
            text-align: center;
            padding: 40px;
            border-radius: 12px;
            background-color: white;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 90%; /* Responsive width */
            max-width: 400px; /* Maximum width */
        }
        h4 {
            color: #00796b; /* Teal color for the heading */
            margin-bottom: 20px;
        }
        .btn {   
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }
        .btn-danger {
            background-color: #d32f2f; /* Red for delete */
            color: white;
        }
        .btn-grey {
            background-color: #e0e0e0; /* Grey for don't delete */
            color: black;
        }
        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }
        .modal-content {
            background-color: white;
            padding: 16px;
            margin: 15% auto; /* 15% from the top and centered */
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            max-width: 600px; /* Maximum width */
            border-radius: 10px; /* Rounded corners */
            text-align: center;
        }
    </style>
</head>
<body>
    <h4 class="mt-4 text-center" style="overflow:hidden">Delete Account</h4>
    
        <div class="form-outline">
            <!-- Delete Button with improved styling -->
            <input type="button" class="btn btn-danger m-4" 
                   value="Delete Account" onclick="openModal()">
        </div>

    <!-- Confirmation Modal -->
    <div id="deleteModal" class="modal" >
        <div class="modal-content">
            <h4 style="overflow:hidden">Are you sure you want to delete your account?</h4>
            <form action="" method="post">
            <button type="submit" class="btn btn-danger my-2" name="confirm_delete">Yes, Delete My Account</button>
            <button type="button" class="btn btn-grey my-2" onclick="closeModal()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById("deleteModal").style.display = "block";
        }
        function closeModal() {
            document.getElementById("deleteModal").style.display = "none";
        }
        // Close modal if user clicks outside of the modal
        window.onclick = function(event) {
            var modal = document.getElementById("deleteModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
