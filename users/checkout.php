<?php
include('../database/connection.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecommerce Website using Php and Mysqli</title>
  <!-- CSS and Font Links -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../style.css">
</head>
<style>
  
@media (max-width: 767px) {
    .form-inline {
        display: flex;
        flex-direction: column; 
        align-items: stretch; 
    }

    .form-control {
        width: 100%; 
        margin-bottom: 10px; /
    }

    .btn {
        width: 20%; 
    }
}

@media (min-width: 768px) {
    .form-inline {
        display: flex;
        flex-direction: row; /* Keep the elements side-by-side on larger screens */
        align-items: center;
    }

    .form-control {
        width: 500px; /* Keep the search input width as is for larger screens */
    }
}

</style>
<body>

<?php
// Check if user is logged in to display navbar and footer
if (isset($_SESSION['user_username'])) {
?>
<!-- Navbar (only for logged-in users) -->
<div class=" p1 container-fluid p-0 gradient-background">
  <nav class=" p1 navbar navbar-expand-lg navbar-dark navbar-color">
    <div class=" p1 container-fluid">
      <img src="../images/logo_new.png" alt="" style="width: 6%; height: 7%; margin-right: 15px; border-radius:5px">
      <button class=" p1 navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class=" p1 navbar-toggler-icon"></span>
      </button>

      <div class=" p1 collapse navbar-collapse" id="navbarSupportedContent">
        <ul class=" p1 navbar-nav mr-auto">
          <li class=" p1 nav-item"><a class=" p1 nav-link nav-zoom" href="../index.php">Products</a></li>
          <li class=" p1 nav-item"><a class=" p1 nav-link nav-zoom" href="./wishlist.php">Wishlist</a></li>
          <?php if (isset($_SESSION['user_username'])): ?>
            <li class=" p1 nav-item"><a class=" p1 nav-link nav-zoom" href="./profile.php">My Account</a></li>
          <?php else: ?>
            <li class=" p1 nav-item"><a class=" p1 nav-link nav-zoom" href="./user_registration.php">Register</a></li>
          <?php endif; ?>
          <li class=" p1 nav-item"><a class=" p1 nav-link nav-zoom" href="../contact_page.php">Contact</a></li>
        </ul>
        <form class="p1 form-inline my-2 my-lg-0" action="../searchProduct.php" method="get">
            <input class="p1 form-control mr-3" type="search" style="width:500px;" placeholder="Search" name="search_data">
            <button class="p1 btn btn-outline-light" type="submit" name="search_data_product">Search</button>
        </form>
      </div>
    </div>
  </nav>
</div>
<?php } ?>

<!-- Main Content -->
<div class=" p1 col-md-12">
  <div class=" p1 row">
    <?php
    // Redirect guests to the login page
    if (!isset($_SESSION['user_username'])) {
        header("Location: user_login.php?from=checkout");
        exit();
    } else {
        include('payment.php');
    }
    ?>
  </div>
</div>

<!-- Footer (only for logged-in users) -->
<?php if (isset($_SESSION['user_username'])): ?>
  <?php getFooter(); ?>
<?php endif; ?>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
