<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <style>
        .btn {
            background-color: #17a2b8; 
            color: #ffffff; 
            border: none; 
            cursor: pointer; 
            transition: background-color 0.3s; 
        }

        .btn:hover {
            background-color: #138496; 
        }
    </style>
    
</head>
<body>
    <h4 class="text-danger mb-4 mt-4 text-center" style="overflow:hidden">Delete Account</h4>
    <form action="" method="post" class="mt-5">
        <div class="form-outline mb-4">
            <input type="submit" class="form-control w-50 m-auto btn" name="delete" value="Delete Account" onclick="return confirmDelete()">
        </div>
        <div class="form-outline mb-3">
            <input type="submit" class="form-control w-50 m-auto btn" name="dont_delete" value="Don't Delete Account">
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
$username_session=$_SESSION['user_username'];
if(isset($_POST['delete'])){
    
    $delete_query="Delete FROM `user` WHERE user_username='$username_session'";
    $result=mysqli_query($conn,$delete_query);
    if($result){
        session_destroy();
        echo "<script>alert('Account Deleted Successfully!')</script>";
        echo " <script>window.open('../index.php','_self')</script";
    }
}

if(isset($_POST['dont_delete'])){
        echo " <script>window.open('profile.php','_self')</script";
    }


?>