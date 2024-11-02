<?php
// Corrected include file name
include('../database/connection.php');
include('../functions/common_function.php');
session_start();

if (isset($_POST['add_to_wishlist'])) {
  if (isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
      
      // Check if it's a book or a tool and assign appropriate variables
      if (isset($_POST['book_id'])) {
          // It's a book
          $book_id = str_replace('b', '', $_POST['book_id']);
          $tool_id = null; // Set tool_id to null because it's a book
          $item_name = $_POST['book_title'];
          $item_image = $_POST['book_image'];
          $item_price = $_POST['book_price'];
      } elseif (isset($_POST['tool_id'])) {
          // It's a tool
          $tool_id = str_replace('t', '', $_POST['tool_id']);
          $book_id = null; // Set book_id to null because it's a tool
          $item_name = $_POST['tool_title'];
          $item_image = $_POST['tool_image'];
          $item_price = $_POST['tool_price'];
      } else {
          // Handle the case where neither 'book_id' nor 'tool_id' is set
          die('Error: Item type not specified.');
      }

      // Check if the item is already in the wishlist
      $check_query = "SELECT * FROM wishlist WHERE user_id='$user_id' AND name='$item_name'";
      $check_result = mysqli_query($conn, $check_query);

      if (mysqli_num_rows($check_result) > 0) {
          echo "<script>alert('This item is already in your wishlist.'); window.location.href='./wishlist.php';</script>";
      } else {
          // Insert item with numeric book_id/tool_id after prefix removal
          $insert_query = "INSERT INTO wishlist (user_id, name, image, price, book_id, tool_id) 
                           VALUES ('$user_id', '$item_name', '$item_image', '$item_price', " . 
                           ($book_id ? "'$book_id'" : 'NULL') . ", " . 
                           ($tool_id ? "'$tool_id'" : 'NULL') . ")";

          if (mysqli_query($conn, $insert_query)) {
              echo "<script>alert('Item added to wishlist successfully!'); window.location.href='./wishlist.php';</script>";
          } else {
              echo "<script>alert('Error adding item to wishlist.'); window.location.href='../index.php';</script>";
          }
      }
  } else {
      echo "<script>alert('Please log in to add items to your wishlist.'); window.location.href='user_login.php';</script>";
  }
}

if (isset($_POST['remove_item'])) {
  $wishlist_id = $_POST['wishlist_id'];

  // Query to delete item from wishlist based on the wishlist_id
  $delete_query = "DELETE FROM wishlist WHERE wishlist_id = '$wishlist_id'";
  if (mysqli_query($conn, $delete_query)) {
      echo "<script>alert('Item removed from wishlist successfully!'); window.location.href='./wishlist.php';</script>";
  } else {
      echo "<script>alert('Error removing item from wishlist.'); window.location.href='./wishlist.php';</script>";
  }
}


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
  <link rel="stylesheet" href="../style.css">
  <style>
    th {
    text-align: center;
    }

    td{
        text-align: center;
    }

    .item-img{
        width:80px;
        height:70px;
    }

    .btn{
      margin-right:15px;
    }
    .operations {
      white-space: nowrap; 
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
              <a class="nav-link nav-zoom" href="../index.php">Products</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-zoom" href="./wishlist.php">Wishlist</a>
            </li>
            <?php
            if (isset($_SESSION['user_username'])) {
              echo "<li class='nav-item'>
                      <a class='nav-link nav-zoom' href='./profile.php'>My Account</a>
                    </li>";
            } else {
              echo "<li class='nav-item'>
                      <a class='nav-link nav-zoom' href='./user_registration.php'>Register</a>
                    </li>";
            }
            ?>   
            <li class="nav-item">
              <a class="nav-link nav-zoom" href="../contact_page.php">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-zoom" href="../cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i><sup><?php cartItem(); ?></sup></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Total Price: RM<?php totalCartPrice(); ?></a>
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
      <nav class="navbar navbar-expand-lg navbar-dark green">
        <ul class="navbar-nav me-auto">
        <?php
        if (isset($_SESSION['user_username'])) {
            echo "<li class='nav-item'>
                    <a class='nav-link text-dark'><b>Welcome " . htmlspecialchars($_SESSION['user_username']) . "</b></a>
                  </li>";
        } else {
            echo "<li class='nav-item'>
                    <a class='nav-link text-dark' href='#'><b>Welcome guest</b></a>
                  </li>";
        }
        if (isset($_SESSION['user_username'])) {
            echo "<li class='nav-item'>
                    <a class='nav-link nav-zoom text-dark' href='./logout.php'><b>Logout</b></a>
                  </li>";
        } else {
            echo "<li class='nav-item'>
                    <a class='nav-link nav-zoom text-dark' href='./user_login.php'><b>Login</b></a>
                  </li>";
        }
        ?>
        </ul>
      </nav>

      <!-- third child -->
      <div class="light-green">
        <h3 class="text-center mt-3" style="overflow: hidden;">Print N Pixel</h3>
        <p class="text-center">Where stories come alive in every format</p>
      </div>
      <?php
      // Get items from wishlist
      $wishlist_query = "SELECT * FROM `wishlist`";
      $result = mysqli_query($conn, $wishlist_query);
      $num_of_rows = mysqli_num_rows($result);
      if ($num_of_rows == 0) {      
          echo "<div class='alert alert-warning text-center my-5' style='margin: 0 auto; width: fit-content;'>
          There are no items in the wishlist.</div>";
      } else {
      ?>

      <div class="container mt-4">
        <tbody>
        <?php
// Get items from wishlist for the logged-in user
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $wishlist_query = "SELECT * FROM wishlist WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $wishlist_query);

    // Check the number of items in the wishlist
    if (mysqli_num_rows($result) == 0) {      
        echo "<div class='alert alert-warning text-center my-5' style='margin: 0 auto; width: fit-content;'>
        There are no items in the wishlist.</div>";
    } else {
        // Display the wishlist if there are items
        echo '<div class="container mt-4">
                <h3 class="text-center mt-5" style="overflow:hidden">Your Wishlist</h3>
                <table class="table table-bordered table-striped center-table mt-4 mb-5">
                    <thead class="green">
                        <tr>
                            <th>Product</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>';

        while ($row = mysqli_fetch_assoc($result)) {
            $item_id = $row['book_id'] ?? $row['tool_id'];
            $item_type = $row['book_id'] ? 'book' : 'tool';
            $item_image = $row['image'];
            $item_title = $row['name'];
            $item_price = $row['price'];

            // Adjust the link to point to the appropriate details page
            $details_link = $item_type === 'book' ? "../bookDetails.php?book_id=b$item_id" : "../toolDetails.php?tool_id=t$item_id";

            echo "<tr>
                    <td class='item-img'><img src='../admin/toolImages/$item_image' class='item-img'></td>
                    <td>$item_title</td>
                    <td>RM$item_price</td>
                    <td class='operations'>
                        <a href='$details_link' class='btn btn-style'>View Details</a>
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='wishlist_id' value='{$row['wishlist_id']}'>
                            <button type='submit' name='remove_item' class='btn btn-danger'>Remove</button>
                        </form>
                    </td>
                </tr>";
        }

        echo '</tbody>
              </table>
              </div>';
    }
} else {
    echo "<div class='alert alert-info text-center my-5' style='margin: 0 auto; width: fit-content;'>
    Please log in to view your wishlist.</div>";
}
?>
</tbody>

    </table>
</div>
<?php } ?>

  <!-- Footer -->
  <?php getFooter(); ?>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>