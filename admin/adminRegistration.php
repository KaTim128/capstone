<?php
include('../functions/common_function.php');

if (isset($_POST['adminRegistration'])) {
    $admin_name = $_POST['username'];
    $admin_email = $_POST['email'];
    $admin_password = $_POST['password'];
    $conf_password = $_POST['conf_password'];
    
    // Error checking
    if (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!')</script>";
        return;
    } elseif (strlen($admin_password) < 8) {
        echo "<script>alert('Password must be at least 8 characters long!')</script>";
        return;
    } elseif ($admin_password !== $conf_password) {
        echo "<script>alert('The confirm password does not match!')</script>";
        return;
    }

    // Password hashing
    $hash_password = password_hash($admin_password, PASSWORD_DEFAULT);

    // Check if admin email already exists
    $select_email_query = "SELECT * FROM admin_table WHERE admin_email='$admin_email'";
    $email_result = mysqli_query($conn, $select_email_query);
    if (mysqli_num_rows($email_result) > 0) {
        echo "<script>alert('Email already exists!')</script>";
        return;
    }

    // Insert admin data into the database
    $insert_query = "INSERT INTO admin_table (admin_name, admin_email, admin_password) VALUES ('$admin_name', '$admin_email', '$hash_password')";
    $sql_execute = mysqli_query($conn, $insert_query);
    if ($sql_execute) {
        echo "<script>alert('Admin registered successfully!')</script>";
        echo "<script>window.open('adminLogin.php', '_self')</script>";
    } else {
        echo "<script>alert('Registration failed. Please try again.')</script>";
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
    <style>
        body {
            overflow-x: hidden;
        }

        /* Adjust spacing between image and form */
        .form-container {
            display: flex;
            align-items: center;
            gap: 20px; /* Adjusts space between the input and the image */
        }

        /* Reduce input width */
        .custom-input {
            width: 80%; /* Smaller width for the input field */
            padding: 10px;
        }
        
        .img-logo {
            max-width: 90%; /* Ensures the logo scales properly */
        }
    </style>
</head>
<body>
    <div class="container-fluid m-3">
        <h2 class="text-center mb-5">Admin Registration</h2>
        <div class="row d-flex justify-content-center align-items-center form-container">
            <div class="col-lg-5 col-md-5">
                <img src="../images/logo_new.png" alt="Admin Registration" class="img-fluid img-logo">
            </div>
            <div class="col-lg-4 col-md-5">
                <form action="" method="post">
                    <div class="form-outline mb-4">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control custom-input" placeholder="Enter your username" required>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control custom-input" placeholder="Enter your email" required>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control custom-input" placeholder="Enter your password" required>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="conf_password" class="form-label">Confirm Password</label>
                        <input type="password" id="conf_password" name="conf_password" class="form-control custom-input" placeholder="Confirm password" required>
                    </div>
                    <div>
                        <input type="submit" class="bg-info py-2 px-3 border-0 mb-3" name="adminRegistration" value="Register">
                        <p class="link-danger">Already have an account? <a href="adminLogin.php">Login</a></p>
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
