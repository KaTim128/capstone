<?php
include('../functions/common_function.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <!-- Bootstrap CSS link -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #7BA17B; /* Green background color */
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 0;
            overflow: hidden; /* Prevent page overflow */
        }

        .registration-container {
            background-color: #ffffff; /* White background for the form */
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: row;
            max-width: 90vw; /* Use more width if needed */
            max-height: 90vh; /* Ensure container fits within viewport */
            width: 100%;
            overflow: hidden; /* Hide overflow */
        }

        .logo-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa; /* Light background for logo area */
            padding: 20px;
            max-height: 100%;
        }

        .logo-container img {
            width: 100%;
            height: auto;
            max-width: 450px; /* Increase max-width to make logo bigger */
            max-height: 80vh; /* Constrain height so it doesn’t overflow */
        }

        .form-container {
            flex: 1.2;
            padding: 20px;
            background-color: #ffffff; /* White background for the form */
            overflow-y: auto; /* Scroll form if necessary */
            max-height: 100%; /* Prevent overflow */
        }

        .form-container h3 {
            color: #495057;
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.7rem; /* Slightly increase the size */
        }

        label {
            color: #000; /* Black label text */
            font-size: 0.85rem;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background for inputs */
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 8px;
            font-size: 0.85rem;
        }

        .btn-register {
            background-color: #C2D6C2; /* Light green button */
            color: #000; /* Black text */
            border: none;
            padding: 12px;
            font-size: 0.9rem;
            width: 50%; /* Set button width */
            border-radius: 6px;
            transition: background-color 0.3s ease;
            margin: 10px auto; /* Use margin auto to center the button */
            display: block; /* Make the button a block element to allow margin auto to work */
            text-align: center; /* Ensure text inside the button is centered */
        }

        .btn-register:hover {
            background-color: #b0c9b0; /* Darker on hover */
        }

        .text-login {
            text-align: center;
            margin-top: 10px;
            color: #495057;
        }

        .text-login a {
            color: #000; /* Black link */
            text-decoration: none;
        }

        .text-login a:hover {
            color: #333; /* Darker on hover */
        }

        /* Mobile view adjustments */
        @media (max-width: 768px) {
            .registration-container {
                flex-direction: column; /* Stack vertically on mobile */
                height: auto; /* Allow height to grow as needed */
                max-width: 100%;
            }

            .logo-container {
                padding: 10px;
                
            }

            .logo-container img {
                width: 100%;
                max-width: 600px; /* Increase width for mobile view */
                max-height: 50vh; /* Adjust max-height to fit in mobile view */
                border-radius:10px;
            }

            .form-container {
                padding: 15px;
                max-height: 50vh; /* Prevent form from causing overflow */
            }

            .form-container h3 {
                font-size: 1.5rem;
            }

            .form-control {
                padding: 6px;
                font-size: 0.85rem;
            }

            .btn-register {
                font-size: 0.85rem;
                padding: 10px;
            }
        }
    </style>

</head>

<body>
    <div class="registration-container">
        <div class="logo-container" >
            <img src="../images/logo_new.png" alt="Logo" style="border-radius:10px;">
        </div>
        <div class="form-container">
            <h3>New User Registration</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="user_username">Username</label>
                    <input type="text" id="user_username" class="form-control" placeholder="Enter your username"
                        name="user_username" required>
                </div>
                <div class="form-group">
                    <label for="user_email">Email</label>
                    <input type="email" id="user_email" class="form-control" placeholder="Enter your email"
                        name="user_email" required>
                </div>
                <div class="form-group">
                    <label for="user_image">Image</label>
                    <input type="file" id="user_image" class="form-control" name="user_image" required>
                </div>
                <div class="form-group">
                    <label for="user_password">Password</label>
                    <input type="password" id="user_password" class="form-control" placeholder="Enter your password"
                        name="user_password" required>
                </div>
                <div class="form-group">
                    <label for="conf_user_password">Confirm Password</label>
                    <input type="password" id="conf_user_password" class="form-control"
                        placeholder="Confirm your password" name="conf_user_password" required>
                </div>
                <div class="form-group">
                    <label for="user_address">Address</label>
                    <input type="text" id="user_address" class="form-control" placeholder="Enter your address"
                        name="user_address" required>
                </div>
                <div class="form-group">
                    <label for="user_contact">Contact</label>
                    <input type="text" id="user_contact" class="form-control" placeholder="Enter your mobile number"
                        name="user_contact" required>
                </div>
                <input type="submit" value="Register" class="btn btn-register mt-4 mb-2" name="user_register">
                <p class="mt-2 text-login">
                    Already have an account? <a href="user_login.php">Login</a>
                </p>
            </form>
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