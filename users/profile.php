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
      width: 90%;
      margin: auto;
      display: block;
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
    border-radius: 5px;
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
  </style>
  
</head>
<body>
    <!-- navbar -->
    <div class="container-fluid p-0">
    <!-- first child  -->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="container-fluid">
        <img src="../images/logo_new.png" alt="" style="width: 6%; height: 7%; margin-right: 15px; border-radius:5px">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="../index.php">Home<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../displayAll.php">Products</a>
            </li>
            <?php
            if(isset($_SESSION['user_username'])){
              echo"<li class='nav-item'>
              <a class='nav-link' href='profile.php'>My Account</a>
            </li>";
            }else{
              echo"<li class='nav-item'>
              <a class='nav-link' href='./users/user_registration.php'>Register</a>
            </li>";
            }
            ?>   
            <li class="nav-item">
              <a class="nav-link" href="../contact_page.php">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i><sup><?php cartItem();?></sup></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Total Price: RM<?php totalCartPrice(); ?></a>
            </li>
          </ul>
          <form class="d-flex form-inline my-2 my-lg-0" action="../searchProduct.php" method="get">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
            <input type="submit" value="search" class="btn btn-outline-light" name="search_data_product">
          </form>
        </div>
    </div>
</nav>

      <!-- call cart function -->
      <?php manageCart(); ?>

      <!-- second child -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <ul class="navbar-nav me-auto">
          <?php
          if (isset($_SESSION['user_username'])) {
            echo "<li class='nav-item'>
            <a class='nav-link' href='#'>Welcome " . $_SESSION['user_username'] . "</a>
          </li>";
          } else {
            echo "<li class='nav-item'>
            <a class='nav-link' href='#'>Welcome guest</a>
          </li>";
          }
          if (isset($_SESSION['user_username'])) {
            echo "<li class='nav-item'>
              <a class='nav-link' href='logout.php'>Logout</a>
            </li>";
          } else {
            echo "<li class='nav-item'>
              <a class='nav-link' href=user_login.php'>Login</a>
            </li>";
          }
          ?>
        </ul>
      </nav>

      <!-- third child -->
      <div class="bg-light">
        <h3 class="text-center" style="overflow: hidden;">Course Store</h3>
        <p class="text-center">Online bookstore for students</p>
      </div>

      <!-- fourth child -->
      <div class="row flex-grow-1">
        <div class="col-md-2 sidebar bg-info">
          <ul class="navbar-nav text-center">
            <li class="text-light bg-secondary">
            <h5 class="profile-header">Your Profile</h5>
            </li>
            <?php
            $username = $_SESSION['user_username'];
            $user_image = "SELECT * FROM `user` WHERE user_username='$username'";
            $result_image = mysqli_query($conn, $user_image);
            $row_image = mysqli_fetch_array($result_image);
            $user_image = $row_image['user_image'];
            echo "<li class='bg-info mt-4 mb-2 img-side' style='overflow:hidden'>
              <img src='./user_images/$user_image' class='profile-img' alt=''>
            </li>";
            ?>
            <li>
              <a class="nav-link text-light" href="profile.php"><h6 style="overflow:hidden;">My Orders</h6></a>
            </li>
            <li>
              <a class="nav-link text-light" href="profile.php?edit_account"><h6 style="overflow:hidden;">Edit Account</h6></a>
            </li> 
            <li>
              <a class="nav-link text-light" href="profile.php?my_orders"><h6 style="overflow:hidden;">Pending Orders</h6></a>
            </li>
            <li>
              <a class="nav-link text-light" href="profile.php?paid_orders"><h6 style="overflow:hidden;">Paid Orders</h6></a>
            </li>    
            <li>
              <a class="nav-link text-light" href="profile.php?delete_account"><h6 style="overflow:hidden;">Delete Account</h6></a>
            </li>
            <li>
              <a class="nav-link text-light" href="logout.php"><h6 style="overflow:hidden;">Logout</h6></a>
            </li>
          </ul>
        </div>
        <div class="col-md-10">
          
          <?php 
          orderDetails(); ?>
        </div>
      </div>

      <!-- last child -->
      <?php getFooter(); ?>
    </div>

    <!-- bootstrap link-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js"></script> 
  </body>
</html>
