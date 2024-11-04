<?php
include('../functions/common_function.php');

if (isset($_POST['adminRegistration'])) {
    $admin_name = $_POST['username'];
    $admin_email = $_POST['email'];
    $admin_password = $_POST['password'];
    $conf_password = $_POST['conf_password'];
    
    // Initialize a flag to check for validation errors
    $is_valid = true;

    // Error checking
    if (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!')</script>";
        $is_valid = false; // Set the flag to false
    } elseif (strlen($admin_password) < 8) {
        echo "<script>alert('Password must be at least 8 characters long!')</script>";
        $is_valid = false; // Set the flag to false
    } elseif ($admin_password !== $conf_password) {
        echo "<script>alert('The confirm password does not match!')</script>";
        $is_valid = false; // Set the flag to false
    }

    // Only proceed if there are no validation errors
    if ($is_valid) {
        // Password hashing
        $hash_password = password_hash($admin_password, PASSWORD_DEFAULT);

        // Check if admin email already exists
        $select_email_query = "SELECT * FROM admin_table WHERE admin_email='$admin_email'";
        $email_result = mysqli_query($conn, $select_email_query);
        if (mysqli_num_rows($email_result) > 0) {
            echo "<script>alert('Email already exists!')</script>";
            $is_valid = false; // Set the flag to false
        }

        // Insert admin data into the database if still valid
        if ($is_valid) {
            $insert_query = "INSERT INTO admin_table (admin_name, admin_email, admin_password) VALUES ('$admin_name', '$admin_email', '$hash_password')";
            $sql_execute = mysqli_query($conn, $insert_query);
            if ($sql_execute) {
                echo "<script>alert('Admin registered successfully!')</script>";
                echo "<script>window.open('adminLogin.php', '_self')</script>";
            } else {
                echo "<script>alert('Registration failed. Please try again.')</script>";
            }
        } else {
            // Redirect back if validation failed
            echo "<script>window.open('adminRegistration.php', '_self')</script>";
        }
    } else {
        // Redirect back if validation failed
        echo "<script>window.open('adminRegistration.php', '_self')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body class="front-background navbar-color">
    <div class="container-fluid m-3 front-background">
        <h2 class="text-center my-5 text-light">Admin Registration</h2>
        <div class="row d-flex justify-content-center align-items-center form-container">
            <div class="col-lg-5 col-md-5">
                <img src="../images/logo_new.png" alt="Admin Registration" class="img-fluid img-logo" style="border-radius:10px;">
            </div>
            <div class="col-lg-4 col-md-5">
                <form action="" method="post">
                    <div class="form-outline mb-4">
                        <label for="username" class="form-label text-light">Username</label>
                        <input type="text" id="username" name="username" class="form-control custom-input" placeholder="Enter your username" required>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="email" class="form-label text-light">Email</label>
                        <input type="email" id="email" name="email" class="form-control custom-input" placeholder="Enter your email" required>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="password" class="form-label text-light">Password</label>
                        <input type="password" id="password" name="password" class="form-control custom-input" placeholder="Enter your password" required>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="conf_password" class="form-label text-light">Confirm Password</label>
                        <input type="password" id="conf_password" name="conf_password" class="form-control custom-input" placeholder="Confirm password" required>
                    </div>
                    <div>
                        <button type="submit" name="adminRegistration" class="btn-style mb-3">Register</button>
                        <p class="text-light">Already have an account? <a href="adminLogin.php" class="link-style">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS links -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
