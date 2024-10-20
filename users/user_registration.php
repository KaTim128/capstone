<?php
include('../functions/common_function.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <!-- bootstrap CSS link -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <h2 class="text-center my-3">
            New User Registration
        </h2>
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-12 col-xl-6">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-outline mb-4">
                        <label for="user_username" class="form-label">Username</label>
                        <input type="text" id="user_username" class="form-control" 
                        placeholder="Enter your username" autocomplete="off" 
                        required="required" name="user_username"/>
                    </div>

                    <div class="form-outline mb-4">
                    <label for="user_email" class="form-label">Email</label>
                        <input type="email" id="user_email" class="form-control" 
                        placeholder="Enter new email" autocomplete="off" 
                        required="required" name="user_email"/>
                    </div>

                    
                    <div class="form-outline mb-4">
                    <label for="user_image" class="form-label">Image</label>
                        <input type="file" id="user_image" class="form-control" 
                        placeholder="Enter your image" autocomplete="off" 
                        required="required" name="user_image"/>
                    </div>

                    <div class="form-outline mb-4">
                    <label for="user_password" class="form-label">Password</label>
                        <input type="password" id="user_password" class="form-control" 
                        placeholder="Enter your password" autocomplete="off" 
                        required="required" name="user_password"/>
                    </div>

                    <div class="form-outline mb-4">
                    <label for="user_password" class="form-label">Confirm Password</label>
                        <input type="password" id="conf_user_password" class="form-control" 
                        placeholder="Confirm your password" autocomplete="off" 
                        required="required" name="conf_user_password"/>
                    </div>

                    <div class="form-outline mb-4">
                        <!-- address -->
                        <label for="user_address" class="form-label">Address</label>
                        <input type="text" id="user_address" class="form-control" 
                        placeholder="Enter your address" autocomplete="off" 
                        required="required" name="user_address"/>
                    </div>

                    <div class="form-outline mb-4">
                        <!-- contact -->
                        <label for="user_contact" class="form-label">Contact</label>
                        <input type="text" id="user_address" class="form-control" 
                        placeholder="Enter your mobile number" autocomplete="off" 
                        required="required" name="user_contact"/>
                    </div>

                    <div class="mt-4 pt-2 mb-0">
                        <input type="submit" value="Register" class="bg-info py-2 px-3 border-0" name="user_register"/>
                        <p class="small fw-bold mt-2 pt-1">Already have an account? <a href="user_login.php" class="text-danger">Login</a></p>
                    </div>
                    </form>
            </div>
        </div>
    </div> 
</body>
</html>

<?php
if(isset($_POST['user_register'])){
    $user_username=$_POST['user_username'];
    $user_email=$_POST['user_email'];
    $user_password=$_POST['user_password'];
    $hash_password=password_hash($user_password,PASSWORD_DEFAULT);
    $conf_user_password=$_POST['conf_user_password'];
    $user_address=$_POST['user_address'];
    $user_contact=$_POST['user_contact'];
    $user_image=$_FILES['user_image']['name'];
    $user_image_temp=$_FILES['user_image']['tmp_name'];
    $user_ip=getIPAddress();

     $select_username_query = "SELECT * FROM `user` WHERE user_username='$user_username'";
     $username_result = mysqli_query($conn, $select_username_query);
     $username_count = mysqli_num_rows($username_result);
 
     $select_email_query = "SELECT * FROM `user` WHERE user_email='$user_email'";
     $email_result = mysqli_query($conn, $select_email_query);
     $email_count = mysqli_num_rows($email_result);
 
     // Error checking
     if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!')</script>";
        return;
     } elseif (strlen($user_password) < 8) {
        echo "<script>alert('Password must be at least 8 characters long!')</script>";
        return;
     } elseif ($username_count > 0) {
        echo "<script>alert('Username already exists!')</script>";
        return;
     } elseif ($email_count > 0) {
        echo "<script>alert('Email already exists!')</script>";
        return;
     } elseif ($user_password != $conf_user_password) {
        echo "<script>alert('The confirm password does not match!')</script>";
        return;
     } else {
    //move_uploaded_file($source, $destination);
    move_uploaded_file($user_image_temp,"./user_images/$user_image");
    $insert_query="INSERT INTO `user` (user_username,
    user_email,user_password,user_image,user_ip,user_address
    ,user_contact) VALUES ('$user_username','$user_email','$hash_password',
    '$user_image','$user_ip','$user_address','$user_contact')";

    $sql_execute=mysqli_query($conn,$insert_query);
    }  

//select cart items
$select_cart_items="SELECT * FROM `cart` WHERE ip_address='$user_ip'";
$result_cart=mysqli_query($conn,$select_cart_items);
$rows_count=mysqli_num_rows($result_cart);
if($rows_count>0){
    $_SESSION['user_username']=$user_username;
    echo "<script>alert('You have you have successfully registered!')</script>";
    echo "<script>window.open('./checkout.php','_self')</script>";
} else{
    echo "<script>alert('You have you have successfully registered!')</script>";
    echo "<script>window.open('user_login.php','_self')</script>";
}
}
?>