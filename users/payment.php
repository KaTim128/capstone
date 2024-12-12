<?php
include('../database/connection.php');
include('../functions/common_function.php');

// Get user ID from the session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Get the logged-in user's ID from the session
} else {
    // Handle the case where the user is not logged in (optional)
    echo "<script>alert('Please log in to access this page.'); window.open('login.php', '_self');</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print N Pixel</title>
    <link rel="icon" type="image/png" href="../images/logo_new.png">
    <!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS file -->
    <link rel="stylesheet" href="style.css">
</head>
<style>
    .paypal-img {
        width: 100%;
        
    }

    .offline-img {
        width: 32%;
        transition: transform 0.2s ease; /* Smooth transition */
    }

    .zoom-out-image {
        transition: transform 0.2s ease; /* Smooth transition */
    }

    .zoom-out-image:hover {
        transform: scale(1.1); /* Zooms out the image */
    }
</style>
<body>
    <div class="container">
        <h2 class="text-center text-dark mt-5" style="overflow:hidden">Payment Options</h2>
        <div class="row d-flex justify-content-center align-items-center">
            
            <div class="col-md-6 text-center" style="overflow:hidden">
                <a href="https://www.paypal.com"  target="_blank">
                <img src="../images/paypal.png" class="paypal-img zoom-out-image" alt="">
                </a>
            </div>

            <div class="col-md-6 text-center zoom-out-image"> <!-- Center text and image -->
                <a href="orders.php?user_id=<?php echo $user_id; ?>" style="text-decoration: none;">
                    <img src="../images/offline4.png" class="offline-img" alt="">
                    <h4 class="text-dark" style="overflow:hidden"><b>Offline</b></h4>
                </a>
            </div>
        </div>
    </div>
</body>

</html>
<?php

// Get user ID from the session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Get the logged-in user's ID from the session
} else {
    // Handle the case where the user is not logged in (optional)
    echo "<script>alert('Please log in to access this page.'); window.open('login.php', '_self');</script>";
    exit();
}
?>
