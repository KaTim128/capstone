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
        <style>
        body {
            background-color: #7BA17B; /* Green background color */
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 0 20px; /* Add padding to the sides of the body */
            overflow: hidden; /* Prevent page overflow */
        }

        .login-container {
            background-color: #ffffff; /* White background for the form */
            border-radius: 15px;
            padding:10px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: row;
            max-width: 1000px; /* Set a maximum width for the entire login container */
            margin: auto; /* Center the container horizontally */
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
            max-width: 450px; /* Ensure logo size is similar to registration */
            max-height: 80vh; /* Constrain height so it doesn’t overflow */
        }

        .form-container {
            flex: 1.2;
            padding: 20px;
            background-color: #ffffff; /* White background for the form */
            overflow-y: auto; /* Scroll form if necessary */
            max-height: 100%; /* Prevent overflow */
            width: 400px; /* Set a fixed width for the form container */
            margin: 0 auto; /* Center the form container */
        }

        .form-container h2 {
            color: #495057;
            text-align: center;
            margin-bottom: 20px;
            
            font-size: 1.7rem; /* Slightly increase the size */
        }

        .form-group {
            text-align: left; /* Center align text within the form group */
        }

        label {
            color: #000; /* Black label text */
            font-size: 0.85rem;
            display: block; /* Ensure labels are block elements for better alignment */
            margin-bottom: 5px; /* Add some space below the label */
            
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background for inputs */
            border: 1px solid #ced4da;
            width: 100%; /* Set width for the input fields */
            justify-content: center;
            border-radius: 6px;
            padding: 8px;
            font-size: 0.85rem;
            margin: 0; /* Center the input fields */
        }

        .btn-login {
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

        .btn-login:hover {
            background-color: #b0c9b0; /* Darker on hover */
        }

        .text-register {
            text-align: center;
            margin-top: 10px;
            color: #495057;
        }

        .text-register a {
            color: #000; /* Black link */
            text-decoration: none;
        }

        .text-register a:hover {
            color: #333; /* Darker on hover */
        }

        /* Mobile view adjustments */
        @media (max-width: 768px) {
            body {
                padding: 0 10px; /* Reduce side padding on smaller screens */
            }
            .login-container {
                flex-direction: column; /* Stack vertically on mobile */
                height: auto; /* Allow height to grow as needed */
                max-width: 90%;
            }

            .logo-container {
                padding: 10px;
            }

            .logo-container img {
                width: 100%;
                max-width: 600px; /* Increase width for mobile view */
                max-height: 50vh; /* Adjust max-height to fit in mobile view */
                border-radius: 10px;
            }

            .form-container {
                padding: 15px;
                max-height: 50vh; /* Prevent form from causing overflow */
            }

            .form-container h2 {
                font-size: 1.5rem;
            }

            .form-control {
                padding: 6px;
                font-size: 0.85rem;
            }

            .btn-login {
                font-size: 0.85rem;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="../images/logo_new.png" alt="Logo" style="border-radius:10px;">
        </div>
        <div class="form-container">
            <h2>User Login</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="user_email">Email</label>
                    <input type="email" id="user_email" class="form-control" placeholder="Enter your email"
                        name="user_email" required>
                </div>
                <div class="form-group">
                    <label for="user_password">Password</label>
                    <input type="password" id="user_password" class="form-control" placeholder="Enter your password"
                        name="user_password" required>
                </div>
                <input type="submit" value="Login" class="btn btn-login mt-4 mb-4" name="user_login">
                <p class="mt-2 text-register">
                    Don't have an account? <a href="user_registration.php">Register</a>
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
