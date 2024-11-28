<?php
include('../database/connection.php');

if (isset($_GET['edit_account'])) {
    $user_session_name = $_SESSION['user_username'];
    $select_query = "SELECT * FROM `user` WHERE user_username='$user_session_name'";
    $result_query = mysqli_query($conn, $select_query);
    if (!$result_query) {
        die("Query Failed: " . mysqli_error($conn));
    }
    $row_fetch = mysqli_fetch_assoc($result_query);
    $user_id = $row_fetch['user_id'];
    $user_username = $row_fetch['user_username'];
    $user_email = $row_fetch['user_email'];
    $user_image = $row_fetch['user_image'];
    $user_address = $row_fetch['user_address'];
    $user_contact = $row_fetch['user_contact'];
}

$show_alert = false;
$error_alert = false;
$error_message = '';

if (isset($_POST['user_update'])) {
    $update_id = $user_id;
    $user_username = mysqli_real_escape_string($conn, $_POST['user_username']);
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $user_address = mysqli_real_escape_string($conn, $_POST['user_address']);
    $user_contact = mysqli_real_escape_string($conn, $_POST['user_contact']);

    if (!empty($_FILES['user_image']['name'])) {
        $user_image = $_FILES['user_image']['name'];
        $user_image_tmp = $_FILES['user_image']['tmp_name'];
        move_uploaded_file($user_image_tmp, "./user_images/$user_image");
    } else {
        $user_image = $row_fetch['user_image'];
    }

    $formatted_phone = preg_replace('~^(?:0?1|601)~', '+601', $user_contact);
    $phone_valid = preg_match('/^\+601[0-9]{8,10}$/', $formatted_phone);
    $address_valid = strlen(trim($user_address)) >= 5;

    if ($phone_valid && $address_valid) {
        $update_data = "UPDATE `user` SET user_username='$user_username', user_email='$user_email',
        user_image='$user_image', user_address='$user_address', user_contact='$formatted_phone' WHERE 
        user_id=$update_id";
        
        $result_query_update = mysqli_query($conn, $update_data);
        if ($result_query_update) {
            $show_alert = true; 
        } else {
            die("Update failed: " . mysqli_error($conn)); // Debugging line
        }
    } else {
        $errors = [];
        if (!$phone_valid) {
            $errors[] = "Invalid phone number format. Please enter a valid Malaysian number.";
        }
        if (!$address_valid) {
            $errors[] = "Must be a valid address.";
        }
        $error_message = implode('\\n', $errors);
        $error_alert = true; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <style>
        /* Alert bar styling */
        #alert-bar, #error-alert {
    text-align: center;
    position: absolute;
    left: 50%; /* Move the alert bars further to the right */
    width: 80%; /* Fixed width for consistency */
    padding: 15px;
    font-size: 18px;
    z-index: 1000;
    opacity: 1; /* Default opacity */
    transform: translateX(-50%); /* Center the element horizontally */
    transition: top 0.5s ease, opacity 0.5s ease; /* Transition effects */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}

#alert-bar {
    background-color: #d4edda; /* Success color */
    color: #1e5855;
    top: -100px; /* Initially hidden above the viewport */
}

#error-alert {
    background-color: #f8d7da; /* Error color */
    color: #721c24;
    top: -100px; /* Initially hidden above the viewport */
}

#alert-bar.active, #error-alert.active {
    left: 50%; /* Further to the right */
    top: 0%; /* Lower position on the screen */ 
    transform: translateX(-50%); /* Ensure it remains centered horizontally */
}



        .close {
            cursor: pointer;
            margin-left: 15px;
            color: inherit; /* Inherit color from parent */
            font-weight: bold;
            overflow: hidden; /* Added overflow hidden */
            display: inline-block; /* Ensure proper box model behavior */
            width: 20px; /* Set a fixed width to control overflow */
            height: 20px; /* Set a fixed height */
            text-align: center; /* Center text inside the button */
        }

        nav {
            position: fixed; /* Keep the nav fixed at the top */
            top: 0;
            left: 0;
            width: 100%;
            background-color: #333; /* Example background color */
            color: white;
            padding: 10px;
            z-index: 2000; /* Higher z-index for nav */
        }
    </style>
</head>
<body>
    <!-- Alert bar for success message -->
    <div id="alert-bar" class="<?php if ($show_alert) echo 'active'; ?>">
        <span>Data updated successfully! Redirecting...</span>
        <span class="close" onclick="removeAlert('alert-bar')">&times;</span>
    </div>

    <!-- Error alert for invalid data -->
    <div id="error-alert" class="<?php if ($error_alert) echo 'active'; ?>">
        <span><?php echo $error_message; ?></span>
        <span class="close" onclick="removeAlert('error-alert')">&times;</span>
    </div>

    <h4 class="mt-4 mb-4 text-center text-success" style="overflow:hidden">Edit Account</h4>
    <form action="" method="post" enctype="multipart/form-data" class="text-center">
        <!-- Form fields -->
        <div class="form-outline mb-4">
            <input type="text" class="form-control w-50 m-auto" name="user_username" value="<?php echo htmlspecialchars($user_username); ?>" placeholder="Username" required>
        </div>
        <div class="form-outline mb-3">
            <input type="email" class="form-control w-50 m-auto" name="user_email" value="<?php echo htmlspecialchars($user_email); ?>" placeholder="Email" required>
        </div>
        <div class="form-outline d-flex w-50 m-auto">
            <input type="file" class="form-control m-auto image-bar" name="user_image">
            <img src="./user_images/<?php echo htmlspecialchars($user_image); ?>" alt="" class="edit-img" style="border-radius:10px">
        </div>
        <div class="form-outline mb-4 mt-3">
            <input type="text" class="form-control w-50 m-auto" name="user_address" value="<?php echo htmlspecialchars($user_address); ?>" placeholder="Address" required>
        </div>
        <div class="form-outline mb-3">
            <input type="text" class="form-control w-50 m-auto" name="user_contact" value="<?php echo htmlspecialchars($user_contact); ?>" placeholder="Contact" required>
        </div>
        <input type="submit" value="Update" class="btn-style mb-4 py-2 px-3 border-0" name="user_update">
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const alertBar = document.getElementById('alert-bar');
        const errorAlert = document.getElementById('error-alert');

        // Handle success alert
        if (alertBar.classList.contains('active')) {
            setTimeout(() => {
                alertBar.style.opacity = '0'; // Fade out before sliding up
                setTimeout(() => {
                    alertBar.classList.remove('active'); // Slide up
                    alertBar.style.display = 'none'; // Hide completely
                }, 500); // Wait for the fade out to finish
            }, 1000); 
            setTimeout(() => {
                window.location.href = 'logout.php'; 
            }, 2000); 
        }

        // Handle error alert with a timeout
        if (errorAlert.classList.contains('active')) {
            setTimeout(() => {
                errorAlert.style.opacity = '0'; // Fade out before sliding up
                setTimeout(() => {
                    errorAlert.classList.remove('active'); // Slide up
                    errorAlert.style.display = 'none'; // Hide completely
                }, 500); // Wait for the fade out to finish
            }, 3000); // Change this duration as needed
        }
    });

    function removeAlert(alertId) {
        const alert = document.getElementById(alertId);
        alert.style.opacity = '0'; // Fade out
        setTimeout(() => {
            alert.classList.remove('active'); // Slide up
            alert.style.display = 'none'; // Hide completely
        }, 500); // Wait for fade out to finish
    }
</script>

</body>
</html>
