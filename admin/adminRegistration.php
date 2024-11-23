<?php
include('../functions/common_function.php');

// Initialize alert message
$alertMessage = '';

if (isset($_POST['adminRegistration'])) {
    $admin_name = $_POST['username'];
    $admin_email = $_POST['email'];
    $admin_password = $_POST['password'];
    $conf_password = $_POST['conf_password'];

    // Initialize a flag to check for validation errors
    $is_valid = true;

    // Error checking
    if (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
        $alertMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Invalid email format!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
        $is_valid = false;
    } elseif (strlen($admin_password) < 8) {
        $alertMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Password must be at least 8 characters long.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
        $is_valid = false;
    } elseif ($admin_password !== $conf_password) {
        $alertMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Password confirmation does not match!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
        $is_valid = false;
    }

    // Only proceed if there are no validation errors
    if ($is_valid) {
        // Password hashing
        $hash_password = password_hash($admin_password, PASSWORD_DEFAULT);

        // Check if admin email already exists
        $select_name_query = "SELECT * FROM admin_table WHERE admin_name='$admin_name'";
        $name_result = mysqli_query($conn, $select_name_query);
        if (mysqli_num_rows($name_result) > 0) {
            $alertMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Admin name already exists!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
            $is_valid = false;
        }

        // Check if admin email already exists
        $select_email_query = "SELECT * FROM admin_table WHERE admin_email='$admin_email'";
        $email_result = mysqli_query($conn, $select_email_query);
        if (mysqli_num_rows($email_result) > 0) {
            $alertMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Email already exists!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
            $is_valid = false;
        }

        // Insert admin data into the database if still valid
        if ($is_valid) {
            $insert_query = "INSERT INTO admin_table (admin_name, admin_email, admin_password) VALUES ('$admin_name', '$admin_email', '$hash_password')";
            $sql_execute = mysqli_query($conn, $insert_query);
            if ($sql_execute) {
                $alertMessage = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    Admin registered successfully!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>';
            } else {
                $alertMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Registration failed. Please try again.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin_style.css">
</head>
<style>
    .alert {
        text-align: center;
    }
</style>
<body class="front-background admin-color">
    <div id="alertContainer">
        <?php echo $alertMessage; ?>
    </div>
    <div class="container-fluid m-3 front-background">
        <h2 class="p1 text-center my-5 text-light">Admin Registration</h2>
        <div class="row d-flex justify-content-center align-items-center form-container">
            <div class="col-lg-5 col-md-5">
                <img src="../images/logo_new.png" alt="Admin Registration" class="img-fluid img-logo" style="border-radius:10px;">
            </div>
            <div class="col-lg-4 col-md-5">
                <form action="" method="post">
                    <div class="form-outline mb-4">
                        <label for="username" class="p1 form-label text-light">Username</label>
                        <input type="text" id="username" name="username" class="p1 form-control custom-input" placeholder="Enter your username" required>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="email" class="p1 form-label text-light">Email</label>
                        <input type="email" id="email" name="email" class="p1 form-control custom-input" placeholder="Enter your email" required>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="password" class="p1 form-label text-light">Password</label>
                        <input type="password" id="password" name="password" class="p1 form-control custom-input" placeholder="Enter your password" required>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="conf_password" class="p1 form-label text-light">Confirm Password</label>
                        <input type="password" id="conf_password" name="conf_password" class="p1 form-control custom-input" placeholder="Confirm password" required>
                    </div>
                    <div>
                        <button type="submit" name="adminRegistration" class="p1 btn-style mb-3">Register</button>
                        <p class="p1 text-light">Already have an account? <a href="adminLogin.php" class="p1 link-style">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    window.onload = function () {
        const alertContainer = document.getElementById("alertContainer");

        // If the alert container has content, make it slide up after 3 seconds
        if (alertContainer.innerHTML.trim() !== "") {
            setTimeout(() => {
                // Slide up the alert
                $(alertContainer).slideUp(600, () => {
                    alertContainer.innerHTML = ""; // Clear the alert after the slide-up animation
                });
            }, 3000);
                   }  
    };
    </script>
</body>
</html>
