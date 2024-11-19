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
    <link rel="stylesheet" href="register_style.css">
</head>

<body>
    <div class=" p1 registration-container">
        <div class=" p1 logo-container">
            <img src="../images/logo_new.png" alt="Logo" style="border-radius:10px;">
        </div>
        <div class=" p1 form-container">
            <h3>New User Registration</h3>
            <div id="alertContainer"></div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class=" p1 form-group">
                    <label for="user_username">Username</label>
                    <input type="text" id="user_username" class=" p1 form-control" placeholder="Enter your username"
                        name="user_username" required>
                </div>
                <div class=" p1 form-group">
                    <label for="user_email">Email</label>
                    <input type="email" id="user_email" class=" p1 form-control" placeholder="Enter your email"
                        name="user_email" required>
                </div>
                <div class=" p1 form-group">
                    <label for="user_image">Image</label>
                    <input type="file" id="user_image" class=" p1 form-control" name="user_image" required>
                </div>
                <div class=" p1 form-group">
                    <label for="user_password">Password</label>
                    <input type="password" id="user_password" class=" p1 form-control" placeholder="Enter your password"
                        name="user_password" required>
                </div>
                <div class=" p1 form-group">
                    <label for="conf_user_password">Confirm Password</label>
                    <input type="password" id="conf_user_password" class=" p1 form-control"
                        placeholder="Confirm your password" name="conf_user_password" required>
                </div>
                <div class=" p1 form-group">
                    <label for="user_address">Address</label>
                    <input type="text" id="user_address" class=" p1 form-control" placeholder="Enter your address"
                        name="user_address" required>
                </div>
                <div class=" p1 form-group">
                    <label for="user_contact">Contact</label>
                    <input type="text" id="user_contact" class=" p1 form-control" placeholder="Enter your mobile number"
                        name="user_contact" required>
                </div>
                <input type="submit" value="Register" class=" p1 btn btn-register mt-4 mb-2" name="user_register">
                <p class=" p1 mt-3 text-register text-center">
                    Already have an account? <a href="user_login.php">Login</a>
                </p>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../script.js"></script>
</body>

</html>

<?php
// Assuming you have already connected to the database
if (isset($_POST['user_register'])) {
    $user_username = $_POST['user_username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $hash_password = password_hash($user_password, PASSWORD_DEFAULT);
    $conf_user_password = $_POST['conf_user_password'];
    $user_address = $_POST['user_address'];
    $user_contact = $_POST['user_contact'];
    $user_image = $_FILES['user_image']['name'];
    $user_image_temp = $_FILES['user_image']['tmp_name'];
    $user_ip = getIPAddress();

    // Check if passwords match
    if ($user_password !== $conf_user_password) {
        echo '<script>document.getElementById("alertContainer").setAttribute("data-alert-message", "Passwords do not match."); document.getElementById("alertContainer").setAttribute("data-alert-type", "danger");</script>';
        exit;
    }  
    
    // Improved regex to validate typical street address format
    $address_regex = '/^[\s\S]{5,}$/';
    
    if (!preg_match($address_regex, $user_address)) {
        echo '<script>document.getElementById("alertContainer").setAttribute("data-alert-message", "Invalid address. Please enter a valid address."); document.getElementById("alertContainer").setAttribute("data-alert-type", "danger");</script>';
        exit;
    }

    $justNums = preg_replace("/[^0-9]/", '', $user_contact);

    // Format the phone number to the standard format used for Malaysian numbers
    $formatted_phone = preg_replace('~^(?:0?1|601)~', '+601', $justNums);

    // Validate if it’s a typical Malaysian mobile number
    if (!preg_match('/^\+601[0-9]{8,10}$/', $formatted_phone)) {
        echo '<script>document.getElementById("alertContainer").setAttribute("data-alert-message", "Invalid phone number. Please enter a valid Malaysian mobile number."); document.getElementById("alertContainer").setAttribute("data-alert-type", "danger");</script>';
        exit;  
    }

    
    // Check if username or email already exists
    $select_username_query = "SELECT * FROM `user` WHERE user_username='$user_username'";
    $username_result = mysqli_query($conn, $select_username_query);
    $username_count = mysqli_num_rows($username_result);
    
    $select_email_query = "SELECT * FROM `user` WHERE user_email='$user_email'";
    $email_result = mysqli_query($conn, $select_email_query);
    $email_count = mysqli_num_rows($email_result);
    
    if ($username_count > 0) {
        echo '<script>document.getElementById("alertContainer").setAttribute("data-alert-message", "Username already exists."); document.getElementById("alertContainer").setAttribute("data-alert-type", "danger");</script>';
    } elseif ($email_count > 0) {
        echo '<script>document.getElementById("alertContainer").setAttribute("data-alert-message", "Email already exists."); document.getElementById("alertContainer").setAttribute("data-alert-type", "danger");</script>';
    } else {
        move_uploaded_file($user_image_temp, "./user_images/$user_image");
    
        $insert_query = "INSERT INTO `user` (user_username, user_email, user_password, user_image, user_address, user_contact, user_ip) VALUES ('$user_username', '$user_email', '$hash_password', '$user_image', '$user_address', '$user_contact', '$user_ip')";
        $result = mysqli_query($conn, $insert_query);
    
        if ($result) {
            echo '<script>document.getElementById("alertContainer").setAttribute("data-alert-message", "Registration successful!"); document.getElementById("alertContainer").setAttribute("data-alert-type", "success");</script>';
            echo "<script>setTimeout(function() { window.location.href = 'user_login.php'; }, 2000);</script>";
        } else {
            echo '<script>document.getElementById("alertContainer").setAttribute("data-alert-message", "Error during registration. Please try again."); document.getElementById("alertContainer").setAttribute("data-alert-type", "danger");</script>';
        }
    }
    
    }

?>

