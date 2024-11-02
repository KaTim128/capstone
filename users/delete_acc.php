<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
</head>
<body>
    <h4 class="mt-4 text-center" style="overflow:hidden">Delete Account</h4>
    <form action="" method="post" class="form-container">
        <div class="form-outline">
            <!-- Delete Button with improved styling -->
            <input type="submit" class="btn btn-danger m-4" 
                   name="delete" value="Delete Account" onclick="return confirmDelete()">
        </div>
        <div class="form-outline">
            <!-- 'Don't Delete' button with a secondary style -->
            <input type="submit" class="btn btn-grey m-2" 
                   name="dont_delete" value="Don't Delete Account">
        </div>
    </form>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete your account?");
        }
    </script>
</body>
</html>

<?php
// PHP code to handle form submissions
$username_session = $_SESSION['user_username'];
if (isset($_POST['delete'])) {
    $delete_query = "DELETE FROM `user` WHERE user_username = '$username_session'";
    $result = mysqli_query($conn, $delete_query);
    if ($result) {
        session_destroy();
        echo "<script>alert('Account Deleted Successfully!')</script>";
        echo "<script>window.open('../index.php', '_self');</script>";
    }
}

if (isset($_POST['dont_delete'])) {
    echo "<script>window.open('profile.php', '_self');</script>";
}
?>
