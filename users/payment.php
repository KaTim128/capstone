<?php
include('../database/connection.php');
include('../functions/common_function.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- bootstrap CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css file -->
    <link rel="stylesheet" href="style.css">
</head>
<style>
.paypal-img{
    width:100%;
}

.offline-img{
    width:32%;
}

.zoom-out-image {
  transition: transform 0.3s ease; /* Smooth transition */
}

.zoom-out-image:hover {
  transform: scale(1.1); /* Zooms out the image */
}

</style>
<body>
    <!-- php code to get user id -->
     <?php
    $user_ip=getIPAddress();
    $get_user="SELECT * FROM `user` WHERE user_ip='$user_ip'";
    $result=mysqli_query($conn,$get_user);
    $run_query=mysqli_fetch_array($result);
    $user_id=$run_query['user_id'];
     ?>
    <div class="container">
    <h2 class="text-center text-info">Payment Options</h2>
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-md-6 text-center"> <!-- Center text and image -->
            <a href="https://www.paypal.com" target="_blank">
                <img src="../images/paypal.png" class="paypal-img zoom-out-image" alt="">
            </a>
        </div>
        <div class="col-md-6 text-center zoom-out-image"> <!-- Center text and image -->
            <a href="orders.php?user_id=<?php echo $user_id ?>"  style="text-decoration: none;">
                <img src="../images/offline4.png" class="offline-img" alt="">
                <h4 class="text-dark"><b>Offline</b></h4>
            </a>
        </div>
    </div>
</div>

</body>
</html>