<?php
// Corrected include file name
include('./database/connection.php');
include('./functions/common_function.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecommerce Website using Php and Mysqli</title>
  <!-- bootstrap CSS link -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <!-- font awesome link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- css file -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- navbar -->
  <div class="container-fluid p-0">
    <!-- first child  -->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="container-fluid">
    <img src="./images/logo_new.png" alt="" style="width: 6%; height: 7%; margin-right: 15px; border-radius:5px">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="displayAll.php">Products</a>
      </li>
      <?php
            if(isset($_SESSION['user_username'])){
              echo"<li class='nav-item'>
              <a class='nav-link' href='./users/profile.php'>My Account</a>
            </li>";
            }else{
              echo"<li class='nav-item'>
              <a class='nav-link' href='./users/user_registration.php'>Register</a>
            </li>";
            }
            ?>  
      <li class="nav-item">
        <a class="nav-link" href="contact_page.php">Contact</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i><sup><?php cartItem();?></sup></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Total Price: RM<?php totalCartPrice(); ?></a>
      </li>
    </ul>
    <form class="d-flex form-inline my-2 my-lg-0" action="searchProduct.php" method="get">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
      <input type="submit" value="search" class="btn btn-outline-light" name="search_data_product">
    </form>
  </div>
</nav>

<!-- second child -->
<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
  <ul class="navbar-nav me-auto">
      <?php
      if(isset($_SESSION['user_username'])){
        echo "<li class='nav-item'>
        <a class='nav-link' href='#'>Welcome ".$_SESSION['user_username']."</a>
      </li>";
      } else {
        echo "<li class='nav-item'>
        <a class='nav-link' href='#'>Welcome guest</a>
      </li>";
      }
        if(isset($_SESSION['user_username'])){
          echo "<li class='nav-item'>
          <a class='nav-link' href='./users/logout.php'>Logout</a>
        </li>";
        }else{
          echo "<li class='nav-item'>
          <a class='nav-link' href='./users/user_login.php'>Login</a>
        </li>";
        }
      ?>
  </ul>
</nav>

<!-- third child -->
<div class="bg-light">
  <h3 class="text-center text">Course Store</h3>
  <p class="text-center">Online bookstore for students</p>
</div>

<!-- fourth child -->
<div class="row px-3">
  <div class="col-md-10">
    <!-- books -->
    <div class="row">

    <!-- calling fetch function-->
    <?php
    viewToolDetails();
    displayAlert(); 
    getUniqueCourses();
    getUniqueTools();
    ?>

  <!-- row end -->
  </div>
<!-- column end -->
</div>          

  <div class="col-md-2 bg-secondary p-0">
    <!-- courses to be displayed -->
    <ul class="navbar-nav me-auto text-center">
      <li class="nav-item bg-info">
        <a href="#" class="nav-link text-light"><h4 style="overflow:hidden;">Courses</h4></a>
      </li>
      <?php
        getCourses();
      ?> 
    </ul>

    <!-- stationaries to be displayed -->
    <ul class="navbar-nav me-auto text-center">
      <li class="nav-item bg-info">
        <a href="#" class="nav-link text-light"><h4 style="overflow:hidden;">Stationaries</h4></a>
      </li>
      <?php
      getStationeries();
      ?>
    </ul>
  </div>
</div>


<!-- last child -->
<?php getFooter(); ?>
</div>

<!-- bootstrap link-->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
