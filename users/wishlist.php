<?php
// Corrected include file name
include('../database/connection.php');
include('../functions/common_function.php');
session_start();

$alertMessage = ''; // Initialize alert message variable

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
            $alertMessage = 'This item is already in your wishlist.';
        } else {
            // Insert item with numeric book_id/tool_id after prefix removal
            $insert_query = "INSERT INTO wishlist (user_id, name, image, price, book_id, tool_id) 
                            VALUES ('$user_id', '$item_name', '$item_image', '$item_price', " . 
                            ($book_id ? "'$book_id'" : 'NULL') . ", " . 
                            ($tool_id ? "'$tool_id'" : 'NULL') . ")";

            if (mysqli_query($conn, $insert_query)) {
                $alertMessage = 'Item added to wishlist successfully!';
            } else {
                $alertMessage = 'Error adding item to wishlist.';
            }
        }
    } else {
        $alertMessage = 'Please log in to add items to your wishlist.';
    }
}

if (isset($_POST['remove_item'])) {
    $wishlist_id = $_POST['wishlist_id'];

    // Query to delete item from wishlist based on the wishlist_id
    $delete_query = "DELETE FROM wishlist WHERE wishlist_id = '$wishlist_id'";
    if (mysqli_query($conn, $delete_query)) {
        $alertMessage = 'Item removed from wishlist successfully!';
    } else {
        $alertMessage = 'Error removing item from wishlist.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print N Pixel</title>
    <link rel="icon" type="image/png" href="../images/logo_new.png">
    <!-- bootstrap CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- css file -->
    <link rel="stylesheet" href="../style.css">
    <style>
        th { text-align: center; }
        td { text-align: center; }
        .item-img { width: 60px; height: 70px; }
        .operations { white-space: nowrap; }
        .alert-fullwidth {
            position: sticky;
            top: 60px; /* Adjust based on your navbar height */
            width: 100%;
            margin: 0;
            z-index: 1050; /* Make sure it appears above other content */
          }

          .persistent-alert {
            margin: 0 auto;
            width: fit-content;
            padding: 15px; /* Add padding for better appearance */
            background-color: #ffeeba; /* Light yellow background color for the alert */
            color: #856404; /* Dark yellow text color */
            border-radius: 0.25rem; /* Rounded corners */
            text-align: center; /* Centered text */
            display: block; /* Ensure it behaves like a block element */
            }


        .form-control {
            width: 400px; /* Width of the search input */
            padding: 0.375rem 0.75rem; /* Padding inside the input */
            border: 1px solid #ced4da; /* Border style */
            border-radius: 0.25rem; /* Rounded corners */
        }

        .btn {
            margin-left: 0px; /* Space between the input and button */
        }

        .form-control {
    width: 400px; /* Adjust as needed */
    padding: 0.375rem 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}

    .box {
    position: absolute;
    top: 20%;
    left: 50%;
    width: 200px;
    height: 42px;
    transform: translate(-50%, -50%);
    text-align: center; 
    line-height: 27px;
    overflow: hidden;
    font-family: sans-serif;

    }

    .table-container {
        width: 100%;
        overflow-x: auto; /* Allow horizontal scrolling */
        -webkit-overflow-scrolling: touch; /* Improve scrolling on iOS */
    }

    table {
        width: 100%;
        table-layout: auto; /* Adjust column width based on content */
    }

    </style>
</head>
<body>
   <!-- navbar -->
  <div class="p1 container-fluid p-0 gradient-background">
    <!-- first child  -->
    <nav class="p1 navbar navbar-expand-lg navbar-dark navbar-color">
      <div class="p1 container-fluid">
        <img src="../images/logo_new.png" alt="" style="width: 6%; height: 7%; margin-right: 15px; border-radius:5px">
        <button class="p1 navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="p1 navbar-toggler-icon"></span>
        </button>

        <div class="p1 collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="p1 navbar-nav mr-auto">
            <li class="p1 nav-item">
              <a class="p1 nav-link nav-zoom text-light" href="../index.php">Products</span></a>
            </li>
            <li class="p1 nav-item">
              <a class="p1 nav-link nav-zoom text-light" href="./wishlist.php">Wishlist</a>
            </li>
            
            <?php
            if (isset($_SESSION['user_username'])) {
              echo "<li class='p1 nav-item'>
                      <a class='p1 nav-link nav-zoom text-light' href='./profile.php'>My Account</a>
                    </li>";
            } else {
              echo "<li class='p1 nav-item'>
                      <a class='p1 nav-link nav-zoom text-light' href='./user_login.php'>Login</a>
                    </li>";
            }
            ?>
            <li class="p1 nav-item">
              <a class="p1 nav-link nav-zoom text-light" href="../contact_page.php">Contact</a>
            </li>   
            <li class="p1 nav-item">
              <a class="p1 nav-link nav-zoom text-light" href="../cart.php">Cart<sup><i class="fa fa-shopping-cart" aria-hidden="true"></i><?php cartItem(); ?></sup></a>
            </li>
            <li class="p1 nav-item">
              <a class="p1 nav-link text-light" href="#">Total Price: RM<?php totalCartPrice(); ?></a>
            </li>
          </ul>
          <!-- Search Bar -->
            <form class="p1 form-inline my-2 my-lg-0" action="../searchProduct.php" method="get">
                <input class="p1 form-control mr-sm-3" type="search" placeholder="Search" aria-label="Search" name="search_data" style="width: 500px;">
                <button class="p1 btn btn-outline-light my-2 my-sm-0" type="submit" name="search_data_product">Search</button>
            </form>
        </div>
      </nav>

      <!-- call cart function -->
      <?php 
      manageCart(); 
      displayAlert(); 
      ?>

        <!-- Alert Handling -->
        <?php if ($alertMessage): ?>
            <div class="p1 alert alert-warning alert-dismissible fade show text-center alert-fullwidth" role="alert">
                <?php echo $alertMessage; ?>
                <button type="button" class="p1 close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Wishlist Content -->
        <div class="p1 container mt-4">
            <?php
            // Get items from wishlist for the logged-in user
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $wishlist_query = "SELECT * FROM wishlist WHERE user_id = '$user_id'";
                $result = mysqli_query($conn, $wishlist_query);

                // Check the number of items in the wishlist
                if (mysqli_num_rows($result) == 0) {
                    echo "<div class='p1 persistent-alert text-center mt-4' style='margin: 0 auto; width: fit-content;'>
                    There are no items in the wishlist.</div>";
                } else {
                    echo '<h3 class="p1 text-center" style="overflow:hidden; margin-top:50px;">Your Wishlist</h3>
                          <div class="table-container">
                          <table class="p1 table table-bordered table-striped center-table mt-4 mb-5">
                          <thead class="p1 table-color">
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
                        $details_link = $item_type === 'book' 
    ? "../bookDetails.php?book_id=b$item_id" : "../toolDetails.php?tool_id=t$item_id";

// Set the image path based on item type
$image_path = $item_type === 'book' 
    ? "../admin/bookImages/$item_image" : "../admin/toolImages/$item_image";

echo "<tr>
        <td class='p1 item-img'><img src='$image_path' class='p1 item-img'></td>
                                    <td>$item_title</td>
                                    <td>RM$item_price</td>
                                    <td class='p1 operations'>
                                        <form action='' method='POST'>
                                            <input type='hidden' name='wishlist_id' value='{$row['wishlist_id']}'>
                                            <button type='submit' class='p1 btn btn-danger' name='remove_item'>Remove</button>
                                            <a href='$details_link' class='p1 btn btn-style'>Details</a>
                                        </form>
                                    </td>
                                </tr>";
                        }
                        echo '</tbody></table></div>';
                    }
                } else {
                    echo "<div class='p1 alert-warning text-center my-3 p-2 box' style='position: absolute; z-index: -1; margin: 0 auto; width: fit-content; border-radius:5px;'>Please log in to view your wishlist.</div>";

                }
                ?>
            </div>
        </div>

    <?php getFooter() ?>
    
    <!-- jQuery, Popper.js, and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // Automatically hide alert after 3 seconds
            setTimeout(function() {
                $('.alert').slideUp(300);
            }, 3000);
        });
    </script>
</body>
</html>
