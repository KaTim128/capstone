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
    <title>Ecommerce Website using Php and Mysqli</title>
    <!-- bootstrap CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- css file -->
    <link rel="stylesheet" href="../style.css">
    <style>
        th { text-align: center; }
        td { text-align: center; }
        .item-img { width: 80px; height: 70px; }
        .btn { margin-right: 15px; }
        .operations { white-space: nowrap; }
        .alert-fullwidth {
            position: sticky;
            top: 60px; /* Adjust based on your navbar height */
            width: 100%;
            margin: 0;
            z-index: 1050; /* Make sure it appears above other content */
          }
    </style>
</head>
<body>
    <!-- navbar -->
    <div class="container-fluid p-0 gradient-background">
        <nav class="navbar navbar-expand-lg navbar-dark navbar-color">
            <div class="container-fluid">
                <img src="../images/logo_new.png" alt="" style="width: 6%; height: 7%; margin-right: 15px; border-radius:5px">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link nav-zoom text-light" href="../index.php">Products</a></li>
                        <li class="nav-item"><a class="nav-link nav-zoom text-light" href="./wishlist.php">Wishlist</a></li>
                        <?php
                        if (isset($_SESSION['user_username'])) {
                            echo "<li class='nav-item'><a class='nav-link nav-zoom text-light' href='./profile.php'>My Account</a></li>";
                        } else {
                            echo "<li class='nav-item'><a class='nav-link nav-zoom text-light' href='./user_login.php'>Login</a></li>";
                        }
                        ?>
                        <li class="nav-item"><a class="nav-link nav-zoom text-light" href="../contact_page.php">Contact</a></li>
                        <li class="nav-item"><a class="nav-link nav-zoom text-light" href="../cart.php">Cart<sup><i class="fa fa-shopping-cart" aria-hidden="true"></i><?php cartItem(); ?></sup></a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="#">Total Price: RM<?php totalCartPrice(); ?></a></li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0" action="../searchProduct.php" method="get">
                        <input class="form-control mr-sm-3" style="width:500px;" type="search" placeholder="Search" name="search_data">
                        <button class="btn btn-outline-light my-2 my-sm-0" value="Search" type="submit" name="search_data_product">Search</button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Alert Handling -->
        <?php if ($alertMessage): ?>
    <div class="alert alert-warning alert-dismissible fade show text-center alert-fullwidth" role="alert">
        <?php echo $alertMessage; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

        <!-- Wishlist Content -->
        <div class="container mt-4">
            <?php
            // Get items from wishlist for the logged-in user
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $wishlist_query = "SELECT * FROM wishlist WHERE user_id = '$user_id'";
                $result = mysqli_query($conn, $wishlist_query);

                // Check the number of items in the wishlist
                if (mysqli_num_rows($result) == 0) {
                    echo "<div class='alert alert-warning text-center my-5' style='margin: 0 auto; width: fit-content;'>There are no items in the wishlist.</div>";
                } else {
                    echo '<h3 class="text-center" style="overflow:hidden; margin-top:20px;">Your Wishlist</h3>
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
                                    <form action='' method='POST'>
                                        <input type='hidden' name='wishlist_id' value='{$row['wishlist_id']}'>
                                        <button type='submit' class='btn btn-danger' name='remove_item'>Remove</button>
                                        <a href='$details_link' class='btn btn-style'>Details</a>
                                    </form>
                                </td>
                              </tr>";
                    }
                    echo '</tbody></table>';
                }
            } else {
                echo "<div class='alert alert-warning text-center my-5' style='margin: 0 auto; width: fit-content;'>Please log in to view your wishlist.</div>";
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
