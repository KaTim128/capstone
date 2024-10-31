<?php
// Start the session and include necessary files
session_start();
include('./database/connection.php');
include('./functions/common_function.php');

// Fetching average rating and total reviews from the database
$query = "SELECT AVG(rating) AS average_rating, COUNT(review_id) AS total_review FROM review";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$average_rating = round($row['average_rating'], 1); // Round to 1 decimal
$total_review = $row['total_review'];

// Fetching total reviews by star rating
$star_count_query = "SELECT 
    SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) AS total_five_star_review,
    SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) AS total_four_star_review,
    SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) AS total_three_star_review,
    SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) AS total_two_star_review,
    SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) AS total_one_star_review
    FROM review";
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

// Initialize user details from the session
$username = $_SESSION['user_username'];
$get_user = "SELECT * FROM `user` WHERE user_username='$username'";
$result = mysqli_query($conn, $get_user);
$row_fetch = mysqli_fetch_assoc($result);
$user_id = $row_fetch['user_id'];
$username = $row_fetch['user_username'];

// Retrieve reviews in order by date
$fetch_reviews = "SELECT * FROM review ORDER BY date DESC"; // Make sure to have a date column for ordering
$reviews_result = mysqli_query($conn, $fetch_reviews);

// Process form submission for reviews
if (isset($_POST['rating']) && isset($_POST['review'])) {
    $rating = $_POST['rating'];
    $review = mysqli_real_escape_string($conn, $_POST['review']);

    $sql = "INSERT INTO review (user_id, name, content, rating) VALUES ('$user_id', '$username', '$review', '$rating')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to the same page after successful submission
        header("Location: " . $_SERVER['PHP_SELF']);
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
    <style>
        .star-light { color: #ddd; }
        .star-warning { color: #ffcc00; }
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
              <a class="nav-link" href="index.php">Products<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./users/wishlist.php">Wishlist</a>
            </li>
            <?php
            if (isset($_SESSION['user_username'])) {
              echo "<li class='nav-item'>
                      <a class='nav-link' href='./users/profile.php'>My Account</a>
                    </li>";
            } else {
              echo "<li class='nav-item'>
                      <a class='nav-link' href='./users/user_registration.php'>Register</a>
                    </li>";
            }
            ?>   
            <li class="nav-item">
              <a class="nav-link" href="contact_page.php">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i><sup><?php cartItem(); ?></sup></a>
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

      <!-- second child -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <ul class="navbar-nav me-auto">
          <?php
          if (isset($_SESSION['user_username'])) {
            echo "<li class='nav-item'>
                    <a class='nav-link'>Welcome " . htmlspecialchars($_SESSION['user_username']) . "</a>
                  </li>";
          } else {
            echo "<li class='nav-item'>
                    <a class='nav-link' href='#'>Welcome guest</a>
                  </li>";
          }
          if (isset($_SESSION['user_username'])) {
            echo "<li class='nav-item'>
                    <a class='nav-link' href='./users/logout.php'>Logout</a>
                  </li>";
          } else {
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

      <!-- forth child -->
      <div class="container">
    <div class="card">
        <div class="card-header"></div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4 text-center">
                    <h1 class="text-warning mt-4 mb-4">
                        <b><span id="average_rating"><?php echo $average_rating; ?></span> / 5</b>
                    </h1>
                    <div class="mb-3">
                        <i class="fas fa-star star-light mr-1 main_star" id="star_1"></i>
                        <i class="fas fa-star star-light mr-1 main_star" id="star_2"></i>
                        <i class="fas fa-star star-light mr-1 main_star" id="star_3"></i>
                        <i class="fas fa-star star-light mr-1 main_star" id="star_4"></i>
                        <i class="fas fa-star star-light mr-1 main_star" id="star_5"></i>
                    </div>
                    <h3><span id="total_review"><?php echo $total_review; ?></span> Reviews</h3>
                </div>
                <div class="col-sm-4">
                    <p>
                        <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i></div>
                        <div class="progress-label-right">(<span id="total_five_star_review"><?php echo $total_five_star_review; ?></span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="<?php echo $five_star_progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $five_star_progress; ?>%;"><?php echo number_format($five_star_progress, 2); ?>%</div>
                        </div>
                    </p>
                    <p>
                        <div class="progress-label-left"><b>4</b> <i class="fas fa-star text-warning"></i></div>
                        <div class="progress-label-right">(<span id="total_four_star_review"><?php echo $total_four_star_review; ?></span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="<?php echo $four_star_progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $four_star_progress; ?>%;"><?php echo number_format($four_star_progress, 2); ?>%</div>
                        </div>
                    </p>
                    <p>
                        <div class="progress-label-left"><b>3</b> <i class="fas fa-star text-warning"></i></div>
                        <div class="progress-label-right">(<span id="total_three_star_review"><?php echo $total_three_star_review; ?></span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="<?php echo $three_star_progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $three_star_progress; ?>%;"><?php echo number_format($three_star_progress, 2); ?>%</div>
                        </div>
                    </p>
                    <p>
                        <div class="progress-label-left"><b>2</b> <i class="fas fa-star text-warning"></i></div>
                        <div class="progress-label-right">(<span id="total_two_star_review"><?php echo $total_two_star_review; ?></span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="<?php echo $two_star_progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $two_star_progress; ?>%;"><?php echo number_format($two_star_progress, 2); ?>%</div>
                        </div>
                    </p>
                    <p>
                        <div class="progress-label-left"><b>1</b> <i class="fas fa-star text-warning"></i></div>
                        <div class="progress-label-right">(<span id="total_one_star_review"><?php echo $total_one_star_review; ?></span>)</div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="<?php echo $one_star_progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $one_star_progress; ?>%;"><?php echo number_format($one_star_progress, 2); ?>%</div>
                        </div>
                    </p>
                </div>
                <div class="col-sm-4 text-center">
                    <!-- Place the review form here -->
                    <div class="review-form">
                        <h4>Submit Your Review</h4>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="rating">Rating:</label>
                                <select name="rating" id="rating" required>
                                    <option value="">Select Rating</option>
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="5">5 Stars</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="review">Review:</label>
                                <textarea name="review" id="review" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Review</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
    function reset_background() {
        $('.submit_star').addClass('star-light').removeClass('star-warning');
    }

    document.addEventListener("DOMContentLoaded", function() {
    const averageRating = parseFloat(document.getElementById("average_rating").innerText);
    const stars = document.querySelectorAll(".main_star");

    // Loop through each star element
    stars.forEach((star, index) => {
        // Change color to 'star-warning' for stars that fall within the average rating
        if (index < Math.floor(averageRating)) {
            star.classList.add("star-warning");
        } else if (index < averageRating) { // Handles partial stars for ratings with decimals
            star.classList.add("star-warning");
            star.style.clipPath = `polygon(0 0, ${((averageRating - index) * 100)}% 0, ${((averageRating - index) * 100)}% 100%, 0% 100%)`;
        } else {
            star.classList.remove("star-warning");
        }
    });
});
</script>
</body>
</html>
