<?php
include('../database/connection.php');
include('../functions/common_function.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecommerce Website using Php and Mysqli</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../style.css">
  <style>
    body {
      display: flex;
      flex-direction: column;
      height: 100vh; /* Full height */
    }
    
    .sidebar {
      height: calc(100vh - 150px); /* Adjust based on the height of the navbar and header */
      overflow-y: auto; /* Scroll if content overflows */
    }

    .profile-img {
    width: 110px;
    height:100px;
    padding: 0px;
    margin: auto;
    display: block;
    border: 3px solid #689d3a;
    border-radius: 50%; /* Keep this for rounded corners */
}

@media (max-width: 768px) {
    .profile-img {
        width: 50%; /* Adjust width for mobile screens */
        max-height: 150px; /* Optional: limit max height */
    }
}


    .hide-bar {
      overflow: hidden;
    }

    .image-bar {
      height: 60px;
      max-height: 60px;
    }

    .img-side {
      width: 130px;          
      height: 110px;         
      object-fit: cover;     
      border-radius: 10px;   
      margin: auto;     
      display: block;        
    }

    .edit-img {
      width: 80px;
      height: 80px;
      object-fit: contain; 
      border-radius: 10px;  
    }

    .form-outline {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      overflow: hidden;
    }

    .profile-header {
    border-radius: 2px;
    background-color: #6c757d; /* Use your preferred color */
    color: white; /* Text color */
    padding: 10px; /* Add some padding */
    text-align: center; /* Center the text */
    overflow: hidden;
    }

    .table-container {
    overflow-x: auto; 
    margin: 20px 0; 
    }

    .single-green{
      background-color:#c1e899;
    }
  </style>
  
</head>

<body>
  <!-- navbar -->
  <div class="container-fluid p-0 gradient-background">
    <!-- first child  -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-color">
      <div class="container-fluid">
        <img src="../images/logo_new.png" alt="" style="width: 6%; height: 7%; margin-right: 15px; border-radius:5px">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link nav-zoom text-light" href="../index.php">Products</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-zoom text-light" href="./wishlist.php">Wishlist</a>
            </li>
            
            <?php
            if (isset($_SESSION['user_username'])) {
              echo "<li class='nav-item'>
                      <a class='nav-link nav-zoom text-light' href='./profile.php'>My Account</a>
                    </li>";
            } else {
              echo "<li class='nav-item'>
                      <a class='nav-link nav-zoom text-light' href='./user_login.php'>Login</a>
                    </li>";
            }
            ?>
            <li class="nav-item">
              <a class="nav-link nav-zoom text-light" href="../contact_page.php">Contact</a>
            </li>   
            <li class="nav-item">
              <a class="nav-link nav-zoom text-light" href="../cart.php">Cart<sup><i class="fa fa-shopping-cart" aria-hidden="true"></i><?php cartItem(); ?></sup></a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light" href="#">Total Price: RM<?php totalCartPrice(); ?></a>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0" action="../searchProduct.php" method="get">
            <input class="form-control mr-sm-3" style="width:500px;" type="search" placeholder="Search" aria-label="Search" name="search_data">
            <button class="btn btn-outline-light my-2 my-sm-0" value="Search" type="submit" name="search_data_product">Search</button>
          </form>
        </div>
      </nav>

      <!-- call cart function -->
      <?php 
      manageCart(); 
      displayAlert(); 
      ?>

      <!-- second child -->
      

      <!-- fourth child -->
      <div class="row flex-grow-1">
        <div class="col-md-2 light-grey">
          <ul class="text-center">
            <h5 class="profile-header green" style="border-radius:0px;">Your Profile</h5>
            <?php
            $username = $_SESSION['user_username'];
            $user_image = "SELECT * FROM `user` WHERE user_username='$username'";
            $result_image = mysqli_query($conn, $user_image);
            $row_image = mysqli_fetch_array($result_image);
            $user_image = $row_image['user_image'];

            echo "
            <li>
              <img src='./user_images/$user_image' class='profile-img mt-3 mb-2' alt=''>
            </li>";
            ?>
            <li>
              <a class="nav-link nav-zoom text-dark" href="profile.php"><h6 style="overflow:hidden;">My Orders</h6></a>
            </li>
            <li>
              <a class="nav-link nav-zoom text-dark" href="profile.php?edit_account"><h6 style="overflow:hidden;">Edit Account</h6></a>
            </li>
            <li>
              <a class="nav-link nav-zoom text-dark" href="profile.php?my_orders"><h6 style="overflow:hidden;">Pending Orders</h6></a>
            </li>
            <li>
              <a class="nav-link nav-zoom text-dark" href="profile.php?paid_orders"><h6 style="overflow:hidden;">Paid Orders</h6></a>
            </li>    
            <li>
              <a class="nav-link nav-zoom text-dark" href="profile.php?delete_account"><h6 style="overflow:hidden;">Delete Account</h6></a>
            </li>
            <li>
              <a class="nav-link nav-zoom text-dark" href="logout.php"><h6 style="overflow:hidden;">Logout</h6></a>
            </li>
          </ul>
        </div>
        <div class="col-md-10">
          
          <?php 
          orderDetails(); ?>
        </div>
      </div>
    </div>
<!-- last child -->
      <?php getFooter(); ?>
    <!-- bootstrap link-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js"></script> 
  </body>
</html>
<script>
    // Refresh the page once to ensure cart items are updated after login
    window.onload = function() {
        // Check if the user just logged in
        if (<?php echo isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] ? 'true' : 'false'; ?>) {
            // Use location.reload() to refresh the page
            location.reload();

            // Unset the session variable to prevent further reloads
            <?php unset($_SESSION['user_logged_in']); ?>
        }
    };
</script>
