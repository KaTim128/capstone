<?php
// Start the session and include necessary files
session_start();
include('./database/connection.php');
include('./functions/common_function.php');

// Determine product_id from URL (either book_id or tool_id)
if (isset($_GET['book_id'])) {
    $product_id = $_GET['book_id'];
} elseif (isset($_GET['tool_id'])) {
    $product_id = $_GET['tool_id'];
} else {
    echo "No product ID provided.";
    exit();
}

// Initialize user details from the session
$username = $_SESSION['user_username'];
$get_user = "SELECT * FROM `user` WHERE user_username='$username'";
$result = mysqli_query($conn, $get_user);
$row_fetch = mysqli_fetch_assoc($result);
$user_id = $row_fetch['user_id'];
$username = $row_fetch['user_username'];
$user_image = $row_fetch['user_image'];

// Check if the user has already submitted a review for this product
$review_check_query = "SELECT * FROM reviews WHERE user_id='$user_id' AND product_id='$product_id'";
$review_check_result = mysqli_query($conn, $review_check_query);
$review_exists = mysqli_num_rows($review_check_result) > 0;

// Fetching average rating and total reviews for the specific product
$query = "SELECT AVG(rating) AS average_rating, COUNT(review_id) AS total_review 
          FROM reviews WHERE product_id='$product_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$average_rating = round($row['average_rating'], 1); // Round to 1 decimal
$total_review = $row['total_review'];

// Fetching total reviews by star rating for the specific product
$star_count_query = "SELECT 
    SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) AS total_five_star_review,
    SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) AS total_four_star_review,
    SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) AS total_three_star_review,
    SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) AS total_two_star_review,
    SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) AS total_one_star_review
    FROM reviews WHERE product_id='$product_id'";

$star_count_result = mysqli_query($conn, $star_count_query);
$star_count_row = mysqli_fetch_assoc($star_count_result);

$total_five_star_review = $star_count_row['total_five_star_review'];
$total_four_star_review = $star_count_row['total_four_star_review'];
$total_three_star_review = $star_count_row['total_three_star_review'];
$total_two_star_review = $star_count_row['total_two_star_review'];
$total_one_star_review = $star_count_row['total_one_star_review'];

// Calculate total reviews and progress for star ratings
$total_reviews = $total_five_star_review + $total_four_star_review + $total_three_star_review + $total_two_star_review + $total_one_star_review;

$five_star_progress = $total_reviews > 0 ? ($total_five_star_review / $total_reviews) * 100 : 0;
$four_star_progress = $total_reviews > 0 ? ($total_four_star_review / $total_reviews) * 100 : 0;
$three_star_progress = $total_reviews > 0 ? ($total_three_star_review / $total_reviews) * 100 : 0;
$two_star_progress = $total_reviews > 0 ? ($total_two_star_review / $total_reviews) * 100 : 0;
$one_star_progress = $total_reviews > 0 ? ($total_one_star_review / $total_reviews) * 100 : 0;

$product_id = isset($_GET['book_id']) ? $_GET['book_id'] : (isset($_GET['tool_id']) ? $_GET['tool_id'] : '');

if (isset($_GET['book_id'])) {
    $product_id = $_GET['book_id'];
    $id = substr($product_id, 1); // Remove the 'b' prefix
    $table = 'books'; // Define the table for books
    $id_column = 'book_id'; // Set the column name for books
} elseif (isset($_GET['tool_id'])) {
    $product_id = $_GET['tool_id'];
    $id = substr($product_id, 1); // Remove the 't' prefix
    $table = 'tools'; // Define the table for tools
    $id_column = 'tool_id'; // Set the column name for tools
} else {
    echo "No product ID provided.";
    exit();
}

// Use the dynamic column name for the query
$image_query = "SELECT image FROM $table WHERE $id_column = '$id'";
$image_result = mysqli_query($conn, $image_query);

// Fetch the image
$image_row = mysqli_fetch_assoc($image_result);

$product_image = $image_row['image'];

if (strpos($product_id, 'b') === 0) { 
    $image_path = 'admin/bookImages/';
} elseif (strpos($product_id, 't') === 0) { 
    $image_path = 'admin/toolImages/';
} else {
    $image_path = 'admin/defaultImages/';
}

// Retrieve reviews for the specific product ID
$fetch_reviews = "SELECT * FROM reviews WHERE product_id='$product_id' ORDER BY review_date DESC";
$reviews_result = mysqli_query($conn, $fetch_reviews);

// Process form submission for reviews
if (isset($_POST['rating']) && isset($_POST['review'])) {
    $rating = $_POST['rating'];
    $review = mysqli_real_escape_string($conn, $_POST['review']);

    // Insert review into the database for the specific product
    $sql = "INSERT INTO reviews (user_id, product_id, review_text, rating) 
            VALUES ('$user_id', '$product_id', '$review', '$rating')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to the same page after successful submission
        header("Location: " . $_SERVER['PHP_SELF'] . "?book_id=" . $product_id); // Assuming book_id is used for redirection
        exit();
    }
}

$order_check_query = "SELECT * FROM orders 
                      WHERE user_id='$user_id' 
                      AND (book_id='$product_id' OR tool_id='$product_id') 
                      AND order_status='complete'";
$order_check_result = mysqli_query($conn, $order_check_query);
$order_exists = mysqli_num_rows($order_check_result) > 0;

// Process form submission for reviews
if (isset($_POST['rating']) && isset($_POST['review'])) {
    $rating = $_POST['rating'];
    $review = mysqli_real_escape_string($conn, $_POST['review']);

    // Insert review into the database for the specific product
    $sql = "INSERT INTO reviews (user_id, product_id, review_text, rating) 
            VALUES ('$user_id', '$product_id', '$review', '$rating')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to the same page after successful submission
        header("Location: " . $_SERVER['PHP_SELF'] . "?book_id=" . $product_id); // Assuming book_id is used for redirection
        exit();
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <title>Review & Rating System in PHP & MySQL using Ajax</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <style>
    .star-light { 
        color: #ddd; 
    }
    .star-warning { 
        color: #ffcc00; 
    }
    .progress-bar {
        transition: width 0.5s ease, opacity 0.5s ease;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    .round-circle {
        border-radius: 50px;
        width: 50px; /* Adjust the width to make the image smaller */
        height: 50px; /* Maintain aspect ratio */
        object-fit: cover; /* Ensures the image covers the dimensions without distortion */
    }

    .product-img {
        border-radius: 10px;
        width: 50px; /* Adjust the width to make the image smaller */
        height: 50px; /* Maintain aspect ratio */
        object-fit: cover; /* Ensures the image covers the dimensions without distortion */
    }
    .progress {
    overflow: hidden; /* Hides overflow for all progress bars */
}
    .progress-bar {
    white-space: nowrap; /* Prevent text from wrapping */
    overflow: hidden; /* Hide any overflow content */
    text-overflow: ellipsis; /* Add ellipsis if content overflows */
}
</style>

</head>
<body>
  <!-- navbar -->
  <div class="container-fluid p-0 gradient-background">
    <!-- first child  -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-color">
      <div class="container-fluid">
        <img src="./images/logo_new.png" alt="" style="width: 6%; height: 7%; margin-right: 15px; border-radius:5px">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link nav-zoom" href="index.php">Products</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-zoom" href="./users/wishlist.php">Wishlist</a>
            </li>
            <?php
            if (isset($_SESSION['user_username'])) {
              echo "<li class='nav-item'>
                      <a class='nav-link nav-zoom' href='./users/profile.php'>My Account</a>
                    </li>";
            } else {
              echo "<li class='nav-item'>
                      <a class='nav-link nav-zoom' href='./users/user_registration.php'>Register</a>
                    </li>";
            }
            ?>   
            <li class="nav-item">
              <a class="nav-link nav-zoom" href="contact_page.php">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-zoom" href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i><sup><?php cartItem(); ?></sup></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Total Price: RM<?php totalCartPrice(); ?></a>
            </li>
          </ul>
        <form class="form-inline my-2 my-lg-0" action="searchProduct.php" method="get">
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

      <!-- forth child -->
      <div class="container mt-5">
        <div class="card">
        <div class="card-header d-flex align-items-center">
            <img src="<?php echo $image_path . $product_image; ?>" class="mr-3 product-img" alt="Product Image" style="width: 100px; height: 100px;">
            <div class="flex-grow-1 text-center">
                <h4 style="overflow:hidden">
                    Rating: 
                    <span class="text-warning"><?php echo $average_rating; ?></span>
                </h4>
                <div class="mb-2">
                    <span class="text-warning">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?php echo $i <= $average_rating ? 'star-warning' : 'star-light'; ?>"></i>
                        <?php endfor; ?>
                    </span>
                </div>
                <span class="float-center"><?php echo $total_review; ?> Reviews</span>
            </div>
        </div>


            <div class="card-body">
            <div class="progress">
            <div class="progress-bar bg-warning" style="width: <?php echo $one_star_progress; ?>%; opacity: <?php echo $one_star_progress > 0 ? 0.2 : 0; ?>" role="progressbar" aria-valuenow="<?php echo $one_star_progress; ?>" aria-valuemin="0" aria-valuemax="100">
                <?php echo $total_one_star_review; ?> (1 Star)
            </div>
            <div class="progress-bar bg-warning" style="width: <?php echo $two_star_progress; ?>%; opacity: <?php echo $two_star_progress > 0 ? 0.4 : 0; ?>" role="progressbar" aria-valuenow="<?php echo $two_star_progress; ?>" aria-valuemin="0" aria-valuemax="100">
                <?php echo $total_two_star_review; ?> (2 Star)
            </div>
            <div class="progress-bar bg-warning" style="width: <?php echo $three_star_progress; ?>%; opacity: <?php echo $three_star_progress > 0 ? 0.6 : 0; ?>" role="progressbar" aria-valuenow="<?php echo $three_star_progress; ?>" aria-valuemin="0" aria-valuemax="100">
                <?php echo $total_three_star_review; ?> (3 Star)
            </div>
            <div class="progress-bar bg-warning" style="width: <?php echo $four_star_progress; ?>%; opacity: <?php echo $four_star_progress > 0 ? 0.8 : 0; ?>" role="progressbar" aria-valuenow="<?php echo $four_star_progress; ?>" aria-valuemin="0" aria-valuemax="100">
                <?php echo $total_four_star_review; ?> (4 Star)
            </div>
            
            <div class="progress-bar bg-warning" style="width: <?php echo $five_star_progress; ?>%; opacity: <?php echo $five_star_progress > 0 ? 1 : 0; ?>" role="progressbar" aria-valuenow="<?php echo $five_star_progress; ?>" aria-valuemin="0" aria-valuemax="100">
                <?php echo $total_five_star_review; ?> (5 Star)
            </div>
            </div>
                <hr/>
                <?php if ($order_exists && !$review_exists): ?>
    <h4 class="text-center" style="overflow:hidden">Submit Your Review</h4>
    <form method="post">
        <div class="form-group">
            <label for="rating">Rating</label>
            <select name="rating" class="form-control" required>
                <option value="">Select Rating</option>
                <option value="5">5 Star</option>
                <option value="4">4 Star</option>
                <option value="3">3 Star</option>
                <option value="2">2 Star</option>
                <option value="1">1 Star</option>
            </select>
        </div>
        <div class="form-group">
            <label for="review">Review:</label>
            <textarea name="review" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-style">Submit Review</button>
    </form>
<?php else: ?>
    <div class="alert alert-success text-center" role="alert">
        <?php if (!$order_exists): ?>
            You need to complete a purchase before leaving a review.
        <?php elseif ($review_exists): ?>
            Thank you for your review! You have already submitted a review for this product.
        <?php endif; ?>
    </div>
<?php endif; ?>

    </div>
        </div>
        <?php
$fetch_reviews = "SELECT r.*, u.user_username, u.user_image 
                  FROM reviews r 
                  JOIN user u ON r.user_id = u.user_id 
                  WHERE r.product_id = '$product_id' 
                  ORDER BY r.review_date DESC";

$reviews_result = mysqli_query($conn, $fetch_reviews);

// Check if there are reviews to display
if (mysqli_num_rows($reviews_result) > 0) {
    echo '<h3 class="mt-5 mb-4 text-center" style="overflow:hidden">User Reviews</h3>';
    while ($review = mysqli_fetch_assoc($reviews_result)) {
        // Extract data from the review and user
        $review_text = htmlspecialchars($review['review_text']);
        $review_rating = $review['rating'];
        $review_date = date("F j, Y", strtotime($review['review_date'])); // Format date
        $review_user_image = $review['user_image'] ?? 'default.jpg'; // Fallback image
        $review_user_name = htmlspecialchars($review['user_username']);

        // Display review
        echo '<div class="review p-3 mb-3 border rounded shadow-sm">';
        echo '<div class="d-flex align-items-center mb-2">';
        echo '<img src="users/user_images/' . $review_user_image . '" class="rounded-circle mr-2" alt="User Image" width="50" height="50">';
        echo '<div>';
        echo '<strong class="font-weight-bold">' . $review_user_name . '</strong>';
        echo '<span class="text-muted d-block">' . $review_date . '</span>';
        echo '</div>';
        echo '</div>'; // End of user info
        echo '<p class="mb-2">' . $review_text . '</p>';

        // Display star rating
        echo '<span class="text-warning">';
        for ($i = 1; $i <= 5; $i++) {
            echo '<i class="fas fa-star ' . ($i <= $review_rating ? 'star-warning' : 'star-light') . '"></i>';
        }
        echo '</span>';
        echo '</div>';
    }
} else {
    echo '<p class="text-muted text-center my-3">No reviews yet.</p>';
}
?>
        <?php while ($review = mysqli_fetch_assoc($reviews_result)): ?>
            <div class="media mb-4">
            <img src="users/user_images/<?php echo $user_image ?>" class="mr-3 round-circle" alt="User Image">
                <div class="media-body">
                    <h5 class="mt-0"><?php echo "$username"?> 
                        <small class="text-muted"><?php echo date('F j, Y', strtotime($review['review_date'])); ?></small>
                    </h5>
                    <span class="text-warning">
                        <?php for ($i = 1; $i <= $review['rating']; $i++): ?>
                            <i class="fas fa-star star-warning"></i>
                        <?php endfor; ?>
                    </span>
                    <p><?php echo htmlspecialchars($review['review_text']); ?></p>
                </div>
            </div>
        <?php endwhile; ?>
      </div>
    </div>

    <!-- Footer -->
    <?php getFooter() ?>
</body>
</html>