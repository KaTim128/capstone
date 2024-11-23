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
  <div class=" p1 container-fluid p-0 gradient-background">
    <!-- first child  -->
    <nav class=" p1 navbar navbar-expand-lg navbar-dark navbar-color">
      <div class=" p1 container-fluid">
        <img src="./images/logo_new.png" alt="" style="width: 6%; height: 7%; margin-right: 15px; border-radius:5px">
        <button class=" p1 navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=" p1 navbar-toggler-icon"></span>
        </button>

        <div class=" p1 collapse navbar-collapse" id="navbarSupportedContent">
          <ul class=" p1 navbar-nav mr-auto">
            <li class=" p1 nav-item">
              <a class=" p1 nav-link nav-zoom text-light" href="index.php">Products</span></a>
            </li>
            <li class=" p1 nav-item">
              <a class=" p1 nav-link nav-zoom text-light" href="./users/wishlist.php">Wishlist</a>
            </li>
            
            <?php
            if (isset($_SESSION['user_username'])) {
              echo "<li class='nav-item'>
                      <a class='p1 nav-link nav-zoom text-light' href='./users/profile.php'>My Account</a>
                    </li>";
            } else {
              echo "<li class='nav-item'>
                      <a class='p1 nav-link nav-zoom text-light' href='./users/user_login.php'>Login</a>
                    </li>";
            }
            ?> 
            <li class=" p1 nav-item">
              <a class=" p1 nav-link nav-zoom text-light" href="contact_page.php">Contact</a>
            </li>  
            <li class=" p1 nav-item">
              <a class=" p1 nav-link nav-zoom text-light" href="cart.php">Cart<sup><i class="fa fa-shopping-cart" aria-hidden="true"></i><?php cartItem(); ?></sup></a>
            </li>
            <li class=" p1 nav-item">
              <a class=" p1 nav-link text-light" href="#">Total Price: RM<?php totalCartPrice(); ?></a>
            </li>
          </ul>
          <form class=" p1 form-inline my-2 my-lg-0" action="searchProduct.php" method="get">
            <input class=" p1 form-control mr-sm-3" style="width:500px;" type="search" placeholder="Search" aria-label="Search" name="search_data">
            <button class=" p1 btn btn-outline-light my-2 my-sm-0" value="Search" type="submit" name="search_data_product">Search</button>
          </form>
        </div>
      </nav>

      <!-- call cart function -->
      <!-- call cart function -->
      <?php 
      manageCart(); 
      displayAlert();

      if (isset($_SESSION['cart_alert'])) {
        $alertMessage = $_SESSION['cart_alert'];
        unset($_SESSION['cart_alert']); // Clear it after using it
    } else {
        $alertMessage = '';
    }
      ?>

<ul class=" p1 navbar-nav me-auto">
    <div class=" p1 alert-placeholder" style="height: 60px;"></div> <!-- Placeholder for alert -->
    <div id="alertContainer" class=" p1 text-center"
         data-alert-message="<?php echo htmlspecialchars($alertMessage); ?>" 
         data-alert-type="success" 
         style="position: absolute; width: 100%; display: block;"></div>
  </ul>

<!-- fourth child -->
<div class=" p1 row px-3">
  <div class=" p1 col-md-10">
    <!-- books -->
    <div class=" p1 row">

    <!-- calling fetch products function-->
    <?php
    searchProducts();
    displayAlert();
    getUniqueCourses();
    getUniqueTools();
    ?>

  <!-- row end -->
  </div>
<!-- column end -->
</div>          

<div class=" p1 col-md-2 p-0 light-grey">
          <!-- Toggle button for Courses -->
          <button class=" p1 btn toggle-btn btn-style w-100 mb-2" type="button" data-toggle="collapse" data-target="#coursesSidebar" aria-expanded="false" aria-controls="coursesSidebar">
            <i class="fas fa-book" style="color: white;"></i> <span style="color: white;">Browse Courses</span>
          </button>

          <!-- Sidebar content for Courses -->
          <div id="coursesSidebar" class=" p1 collapse">
            <!-- courses to be displayed -->
            <ul class=" p1 navbar-nav me-auto text-center">
              <?php getCourses(); ?> 
            </ul>
          </div>

          <!-- Toggle button for Stationeries -->
          <button class=" p1 btn toggle-btn btn-style w-100 mb-2" type="button" data-toggle="collapse" data-target="#stationeriesSidebar" aria-expanded="false" aria-controls="stationeriesSidebar">
            <i class="fas fa-pencil-alt" style="color: white;"></i> <span style="color: white;">Browse Stationeries</span>
          </button>

          <!-- Sidebar content for Stationeries -->
          <div id="stationeriesSidebar" class=" p1 collapse">
            <!-- stationaries to be displayed -->
            <ul class=" p1 navbar-nav me-auto text-center">
              <?php getStationeries(); ?>
            </ul>
          </div>
        </div>
</div>
</div>
<!-- last child -->
<?php getFooter(); ?>


<!-- bootstrap link-->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>