<?php
include('../database/connection.php');
include('../functions/common_function.php');
@session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS link -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #7BA17B; /* Green background color */
            margin: 0; /* Remove default margin */
            display: flex; /* Use flexbox layout */
            justify-content: center; /* Center content horizontally */
            align-items: center; /* Center content vertically */
            overflow-x: hidden;
           
        }

        .login-container {
            display: flex; /* Use flexbox for the container */
            max-width: 800px; /* Limit maximum width of the container */
            width: 100%; /* Occupy full width */
            margin: auto; /* Center container in the middle */
            border-radius: 10px; /* Rounded corners for the container */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); /* Shadow effect for the container */
            overflow: hidden; /* Prevent overflow of child elements */
        }

        .logo-container {
            flex: 1; /* Logo takes up equal space */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px; /* Add padding around the logo */
        }

        .logo-container img {
            width: 100%; /* Make the logo fill its container */
            height: auto; /* Maintain aspect ratio */
            max-width: 300px; /* Limit the maximum size of the logo */
        }

        .form-container {
            flex: 1; /* Form takes up equal space */
            padding: 20px; /* Added padding for better spacing */
            background-color: white; /* White background for the form */
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background for inputs */
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            color: #000; /* Black text for inputs */
        }

        .form-control::placeholder {
            color: #000; /* Black placeholder text */
        }

        .btn-login {
            background-color: #C2D6C2; /* Light green button */
            color: #000; /* Black text */
            border: none;
            padding: 10px 20px;
        }

        .btn-login:hover {
            background-color: #b0c9b0;
        }

        h2 {
            color: #000; /* Black heading */
            text-align: center; /* Center align the heading */
        }

        label {
            color: #000; /* Black label text */
        }

        .text-register {
            color: #000; /* Black text for registration link */
            text-align: center; /* Center the registration link */
        }

        .text-register a {
            color: #000; /* Black link */
            text-decoration: none;
        }

        .text-register a:hover {
            color: #333; /* Darker on hover */
        }

        .forgot-password {
            color: #000; /* Black text */
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-password:hover {
            color: #333; /* Darker on hover */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-container {
                max-width: 100%; /* Adjust max width for smaller screens */
            }

            .logo-container img {
                width: 80%; /* Limit logo size on smaller screens */
            }
        }
    </style>
</head>

<body>
    <div class="login-container mt-5 mb-5">
        <div class="logo-container">
            <img src="../images/logo_new.png" alt="Logo">
        </div>
        <div class="form-container">
            <h2>Login</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="user_email">Email</label>
                    <input type="text" id="user_email" class="form-control" placeholder="Enter your email" name="user_email" required>
                </div>
                <div class="form-group">
                    <label for="user_password">Password</label>
                    <input type="password" id="user_password" class="form-control" placeholder="Enter your password" name="user_password" required>
                </div>
                <input type="submit" value="login" class="btn btn-primary btn-block btn-login" name="user_login">
                <p class="mt-2 text-register">
                    Don't have an account? <a href="user_registration.php">Register</a>
                </p>
                <p class="mt-2 text-register">
                <a href="../index.php">login as guest</a>
                </p>
            </form>
        </div>
    </div>
</body> 
</html>

<?php
if(isset($_POST['user_login'])){
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    // Select user based on email
    $select_query = "SELECT * FROM `user` WHERE user_email = '$user_email'";
    $result = mysqli_query($conn, $select_query);
    $row_count = mysqli_num_rows($result);
    
    if($row_count > 0){
        $row_data = mysqli_fetch_assoc($result);
        $user_ip = getIPAddress();

        // Verify password
        if(password_verify($user_password, $row_data['user_password'])){
            $_SESSION['user_username'] = $row_data['user_username']; // Store the username in session

            // Check for items in cart
            $select_query_cart = "SELECT * FROM `cart` WHERE ip_address = '$user_ip'";
            $select_cart = mysqli_query($conn, $select_query_cart);
            $row_count_cart = mysqli_num_rows($select_cart);

            if($row_count_cart == 0){
                echo "<script>alert('You have successfully logged in!')</script>";
                echo "<script>window.open('profile.php','_self')</script>";
            } else {
                echo "<script>alert('You have successfully logged in! Redirecting to payment.')</script>";
                echo "<script>window.open('checkout.php','_self')</script>";
            }
        } else {
            echo "<script>alert('Invalid Password')</script>";
        }
    } else {
        echo "<script>alert('No user found with this email')</script>";
    }
}
?>
