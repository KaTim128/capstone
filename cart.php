<?php
// Corrected include file name
include('./database/connection.php');
include('./functions/common_function.php');
session_start();

// Include the connection and common functions
$get_ip_add = getIPAddress();
$total_price = 0;

// Handle update cart action
if (isset($_POST['update_cart'])) {
    foreach ($_POST['qty'] as $id => $quantity) {
        // Ensure quantity is numeric and greater than 0
        $quantity = intval($quantity);
        if ($quantity > 0) {
            // Check if it's a book by prefix 'b'
            if (strpos($id, 'b') === 0) {
                // Remove 'b' prefix to get the actual book ID
                $book_id = substr($id, 1);
                // Get book type (only for books)
                $booktype = isset($_POST['booktype'][$id]) ? $_POST['booktype'][$id] : 'digital'; // Default to 'digital' if not set
                // Update quantity and book type for books
                $update_cart = "UPDATE `cart` SET quantity='$quantity', booktype='$booktype' WHERE book_id='$book_id' AND ip_address='$get_ip_add'";
                mysqli_query($conn, $update_cart);
            }
            // Check if it's a tool by prefix 't'
            elseif (strpos($id, 't') === 0) {
                // Remove 't' prefix to get the actual tool ID
                $tool_id = substr($id, 1);
                // Update quantity for tools (tools do not have a booktype)
                $update_cart = "UPDATE `cart` SET quantity='$quantity' WHERE tool_id='$tool_id' AND ip_address='$get_ip_add'";
                mysqli_query($conn, $update_cart);
            }
        }
    }
    // Redirect after update
    echo "<script>window.open('cart.php', '_self');</script>";
}

// Handle remove action
if (isset($_POST['remove_cart'])) {
    foreach ($_POST['remove'] as $remove_id) {
        // Check if it's a book by prefix 'b'
        if (strpos($remove_id, 'b') === 0) {
            // Remove 'b' prefix to get the actual book ID
            $book_id = substr($remove_id, 1);
            // Delete the book from the cart
            $delete_query = "DELETE FROM `cart` WHERE book_id='$book_id' AND ip_address='$get_ip_add'";
            mysqli_query($conn, $delete_query);
        }
        // Check if it's a tool by prefix 't'
        elseif (strpos($remove_id, 't') === 0) {
            // Remove 't' prefix to get the actual tool ID
            $tool_id = substr($remove_id, 1);
            // Delete the tool from the cart
            $delete_query = "DELETE FROM `cart` WHERE tool_id='$tool_id' AND ip_address='$get_ip_add'";
            mysqli_query($conn, $delete_query);
        }
    }
    // Redirect after deletion
    echo "<script>window.open('cart.php', '_self');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecommerce Website - Cart Details</title>
  <!-- bootstrap CSS link -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <!-- font awesome link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- css file -->
  <link rel="stylesheet" href="style.css">
  <style>
    th {
    text-align: center;
    }

    td{
        text-align: center;
    }

    .cart-img{
        width:80px;
        height:70px;
    }

    .center-table{
        margin:0 auto;
        width:70%;
    }
  </style>
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
        <a class="nav-link" href="#">Contact</a>
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

<!-- call cart function -->
<?php
manageCart();
?>

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
          <a class='nav-link' href='logout.php'>Logout</a>
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
  <h3 class="text-center" style="overflow: hidden;">Course Store</h3>
  <p class="text-center">Online bookstore for students</p>
</div>

<!-- Cart Table -->
<div class="container">
  <div class="table-responsive">
    <form action="cart.php" method="post">
      <?php
      // Get items from cart
      $cart_query = "SELECT * FROM `cart` WHERE ip_address='$get_ip_add'";
      $result = mysqli_query($conn, $cart_query);
      $num_of_rows = mysqli_num_rows($result);
      if ($num_of_rows == 0) {      
          echo "<div class='alert alert-warning text-center mt-5' style='margin: 0 auto; width: fit-content;'>
          There are no items in the cart. Head to the shop to buy some!</div>";
      } else {
          // Only display the table if there are items in the cart
          ?>
          <table class="table table-bordered table-striped center-table mt-5">
            <thead>
              <tr>
                <th>Product Title</th>
                <th>Product Image</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Type</th>
                <th>Remove</th>
                <th colspan="2">Operations</th>
              </tr>
            </thead>
            <tbody>
          <?php
          while ($row = mysqli_fetch_array($result)) {
              $book_id = $row['book_id'];
              $tool_id = $row['tool_id'];
              $quantity = $row['quantity'];

              if (!empty($book_id)) {
                  $select_books = "SELECT * FROM `books` WHERE book_id='$book_id'";
                  $result_books = mysqli_query($conn, $select_books);
                  $book = mysqli_fetch_array($result_books);

                  $book_price = $book['price'];
                  $book_title = $book['book_title'];
                  $book_image = $book['image'];
                  $total_price += $book_price * $quantity;
                  ?>
                  <tr>
                    <td><?php echo $book_title; ?></td>
                    <td><img src="./images/<?php echo $book_image; ?>" alt="" class="cart-img img-fluid"></td>
                    <td><input type="number" name="qty[b<?php echo $book_id; ?>]" value="<?php echo $quantity; ?>" class="form-input w-70" min="1" max="10" oninput="this.value = Math.max(this.value, 1)"></td>
                    <td>RM<?php echo $book_price * $quantity; ?>/-</td>
                    <td>
                        <select name="booktype[b<?php echo $book_id; ?>]">
                            <option value="digital" <?php echo ($row['booktype'] == 'digital') ? 'selected' : ''; ?>>Digital</option>
                            <option value="printed" <?php echo ($row['booktype'] == 'printed') ? 'selected' : ''; ?>>Printed</option>
                        </select>
                    </td>
                    <td><input type="checkbox" name="remove[]" value="b<?php echo $book_id; ?>"></td>
                    <td colspan="2">
                        <input type="submit" value="Update Cart" class="bg-info px-3 py-1 mx-3 mb-3 mt-3 border-0" name="update_cart">
                        <input type="submit" value="Remove" class="bg-danger px-3 py-1 mb-3 border-0" name="remove_cart">
                    </td>
                  </tr>
                  <?php
              }

              if (!empty($tool_id)) {
                  $select_tools = "SELECT * FROM `tools` WHERE tool_id='$tool_id'";
                  $result_tools = mysqli_query($conn, $select_tools);
                  $tool = mysqli_fetch_array($result_tools);

                  $tool_price = $tool['price'];
                  $tool_title = $tool['tool_title'];
                  $tool_image = $tool['image'];
                  $total_price += $tool_price * $quantity;
                  ?>
                  <tr>
                      <td><?php echo $tool_title; ?></td>
                      <td><img src="./images/<?php echo $tool_image; ?>" alt="" class="cart-img img-fluid"></td>
                      <td><input type="number" name="qty[t<?php echo $tool_id; ?>]" value="<?php echo $quantity; ?>" class="form-input w-70" min="1" max="10" oninput="this.value = Math.max(this.value, 1)"></td>
                      <td>RM<?php echo $tool_price * $quantity; ?>/-</td>
                      <td></td>
                      <td><input type="checkbox" name="remove[]" value="t<?php echo $tool_id; ?>"></td>
                      <td colspan="2">
                          <input type="submit" value="Update Cart" class="bg-info px-3 py-1 mx-3 mb-3 mt-3 border-0" name="update_cart">
                          <input type="submit" value="Remove" class="bg-danger px-3 py-1 mb-3 border-0" name="remove_cart">
                      </td>
                  </tr>
                  <?php
              }
          }
          ?>
          </tbody>
          </table>
          <?php
      }
      ?>
    </form>
  </div>
</div>

      <!-- total price -->
      <div class="container mb-5">
        <h4 class="mb-3 mt-5" style="overflow: hidden;">Total Price: RM<?php echo $total_price; ?></h4>
        <a href="index.php" class="btn btn-success mr-2">Continue Shopping</a>
        
        <?php if($num_of_rows > 0){ ?>
          <a href="./users/checkout.php" class="btn btn-warning">Checkout</a>
        <?php } ?>
      </div>
    </div>
  </div>

  <?php getFooter(); ?>

<!-- Bootstrap JS and other scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>