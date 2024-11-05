<?php
if (isset($_GET['edit_account'])) {
    $user_session_name = $_SESSION['user_username']; //session get the username
    $select_query = "SELECT * FROM `user` WHERE user_username='$user_session_name'";
    $result_query = mysqli_query($conn, $select_query);
    $row_fetch = mysqli_fetch_assoc($result_query);
    $user_id = $row_fetch['user_id'];
    $user_username = $row_fetch['user_username'];
    $user_email = $row_fetch['user_email'];
    $user_image = $row_fetch['user_image'];
    $user_address = $row_fetch['user_address'];
    $user_contact = $row_fetch['user_contact'];
}

$show_alert = false; // Initialize alert flag
$error_alert = false; // Initialize error alert flag
$error_message = ''; // Initialize error message

if (isset($_POST['user_update'])) {
    $update_id = $user_id;
    $user_username = $_POST['user_username'];
    $user_email = $_POST['user_email'];
    $user_address = $_POST['user_address'];
    $user_contact = $_POST['user_contact'];

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
            $show_alert = true; // Set alert flag to true
        }
    } else {
        $errors = [];
        if (!$phone_valid) {
            $errors[] = "Invalid phone number format. Please enter a valid Malaysian number.";
        }
        if (!$address_valid) {
            $errors[] = "Address must be at least 5 characters long.";
        }
        $error_message = implode('\\n', $errors);
        $error_alert = true; // Set error alert flag to true
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
    display: none;
    position: fixed;
    top: 80; /* Adjusted for better visibility */
    left: 58%; /* Align to the center horizontally */
    width: 600px; /* Fixed width for consistency */
    padding: 15px;
    font-size: 18px;
    z-index: 1000;
    transition: top 0.5s ease, opacity 0.5s ease; /* Added opacity transition */
    opacity: 1; /* Default opacity */
    transform: translateX(-50%); /* Move the element left by half its width */
}

    #alert-bar {
        background-color: #d4edda; /* Success color */
        color: #1e5855;
    }
    #error-alert {
        background-color: #f8d7da; /* Error color */
        color: #721c24;
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
    <div id="alert-bar" <?php if ($show_alert) echo 'style="display: block;"'; ?>>
        <span>Data updated successfully! Redirecting...</span>
        <span class="close" onclick="removeAlert('alert-bar')">&times;</span>
    </div>

    <!-- Error alert for invalid data -->
    <div id="error-alert" <?php if ($error_alert) echo 'style="display: block;"'; ?>>
        <span><?php echo $error_message; ?></span>
        <span class="close" onclick="removeAlert('error-alert')">&times;</span>
    </div>

    <h4 class="mt-4 mb-4 text-center text-success" style="overflow:hidden">Edit Account active</h4>
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
            <img src="./user_images/<?php echo htmlspecialchars($user_image); ?>" alt="" class="edit-img" style="border-radius:15px">
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
        // Show alert bar on successful update
        document.addEventListener('DOMContentLoaded', function() {
            const alertBar = document.getElementById('alert-bar');
            const errorAlert = document.getElementById('error-alert');
            if (alertBar.style.display === 'block') {
                setTimeout(() => {
                    alertBar.style.transition = "top 0.5s ease, opacity 0.5s ease"; // Ensure transition is applied
                    alertBar.style.opacity = '0'; // Fade out
                    setTimeout(() => {
                        alertBar.style.display = 'none'; // Hide after fade
                    }, 500); // Wait for the fade to finish
                }, 3000); // 3 seconds before sliding up
                setTimeout(() => {
                    window.location.href = 'logout.php'; // Redirect after alert has slid up
                }, 4000); // 1 second after alert slides up
            } else {
                alertBar.style.display = 'none'; // Reset display style
            }
            if (errorAlert.style.display === 'block') {
                errorAlert.classList.add('slide-down');
            } else {
                errorAlert.style.display = 'none'; // Reset display style
            }
        });

        function removeAlert(alertId) {
            const alertBar = document.getElementById(alertId);
            alertBar.style.transition = "top 0.5s ease, opacity 0.5s ease"; // Transition for the closing effect
            alertBar.style.opacity = '0'; // Fade out
            setTimeout(() => {
                alertBar.style.display = 'none'; // Hide after fade
            }, 500); // Wait for the fade to finish
        }
    </script>
</body>
</html>
