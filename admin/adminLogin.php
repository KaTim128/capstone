<?php
include('../functions/common_function.php');

if (isset($_POST['admin_registration'])) {
    $admin_email = $_POST['email'];
    $admin_password = $_POST['password'];

    // Fetch the admin record based on email
    $select_query = "SELECT * FROM admin_table WHERE admin_email='$admin_email'";
    $result = mysqli_query($conn, $select_query);
    
    if (mysqli_num_rows($result) > 0) {
        $admin_data = mysqli_fetch_assoc($result);
        
        // Verify the password
        if (password_verify($admin_password, $admin_data['admin_password'])) {
            // Password is correct; start session
            session_start();
            $_SESSION['admin_name'] = $admin_data['admin_name'];
            $_SESSION['admin_email'] = $admin_email;
            $_SESSION['admin_id'] = $admin_data['admin_id']; // Store admin_id in session
            header("Location: adminPanel.php");
            exit();
        } else {
            echo "<script>alert('Invalid password!')</script>";
        }
    } else {
        echo "<script>alert('No account found with this email!')</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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
        <h2 class="text-center mb-5">Admin Login</h2>
        <div class="row d-flex justify-content-center align-items-center form-container">
            <div class="col-lg-5 col-md-5">
                <img src="../images/logo_new.png" alt="Admin Registration" class="img-fluid img-logo">
            </div>
            <div class="col-lg-4 col-md-5">
                <form action="" method="post">
                    <div class="form-outline mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" id="email" name="email" class="form-control custom-input" placeholder="Enter your email" required>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control custom-input" placeholder="Enter your password" required>
                    </div>
                    <div>
                        <input type="submit" class="bg-info py-2 px-3 border-0 mb-3" name="admin_registration" value="Login">
                        <p class="link-danger">Don't have an account? <a href="adminRegistration.php">Register</a></p>
                    </div>
                    <div>
                    <p class="link-danger">Leave admin page? <a href="../users/user_login.php">Back</a></p>
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

