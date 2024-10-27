<?php
include('../database/connection.php');
include('../functions/common_function.php');
@session_start();

$alert_message = ''; // Initialize an empty message
$alert_type = ''; // Initialize an empty alert type

if(isset($_POST['user_login'])){
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    if($user_email == 'admin@gmail.com' && $user_password == '22222222'){
        $alert_message = "Welcome Admin! Redirecting to admin login.";
        $alert_type = 'success';
        echo "<script>setTimeout(function(){ window.location.href = '../admin/adminLogin.php'; }, 1000);</script>";
    } else {
        $select_query = "SELECT * FROM `user` WHERE user_email = '$user_email'";
        $result = mysqli_query($conn, $select_query);
        $row_count = mysqli_num_rows($result);
        
        if($row_count > 0){
            $row_data = mysqli_fetch_assoc($result);
            $user_ip = getIPAddress();

            if(password_verify($user_password, $row_data['user_password'])){
                $_SESSION['user_id'] = $row_data['user_id'];
                $_SESSION['user_username'] = $row_data['user_username']; 

                $select_query_cart = "SELECT * FROM `cart` WHERE ip_address = '$user_ip'";
                $select_cart = mysqli_query($conn, $select_query_cart);
                $row_count_cart = mysqli_num_rows($select_cart);

                if($row_count_cart == 0){
                    $alert_message = "You have successfully logged in!";
                    $alert_type = 'success';
                    echo "<script>setTimeout(function(){ window.location.href = 'profile.php'; }, 1000);</script>";
                } else {
                    $alert_message = "You have successfully logged in! Redirecting to payment.";
                    $alert_type = 'success';
                    echo "<script>setTimeout(function(){ window.location.href = 'checkout.php'; }, 1000);</script>";
                }
            } else {
                $alert_message = "Invalid Credentials. Try Again.";
                $alert_type = 'danger';
            }
        } else {
            $alert_message = "Invalid Credentials. Try Again.";
            $alert_type = 'danger';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link rel="stylesheet" href="login_style.css">
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="../images/logo_new.png" alt="Logo" style="border-radius:10px;">
        </div>
        <div class="form-container">
            <h2>User Login</h2>
            <div id="alertContainer" class="alert-container" data-alert-message="<?= htmlspecialchars($alert_message) ?>" data-alert-type="<?= $alert_type ?>">
            </div>
            <form action="" method="post">
                <div class="form-group">
                    <label for="user_email">Email</label>
                    <input type="email" id="user_email" class="form-control" placeholder="Enter your email" name="user_email" required>
                </div>
                <div class="form-group">
                    <label for="user_password">Password</label>
                    <input type="password" id="user_password" class="form-control" placeholder="Enter your password" name="user_password" required>
                </div>
                <input type="submit" value="Login" class="btn btn-login mt-4 mb-4" name="user_login">
                <p class="mt-2 text-register">
                    Login as guest? <a href="../index.php">Click Here</a>
                </p>
                <p class="mt-2 text-register">
                    Don't have an account? <a href="user_registration.php">Register</a>
                </p>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../script.js"></script>
</body>
</html>
