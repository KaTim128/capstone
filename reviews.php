<?php
// Corrected include file name
include('./database/connection.php');
include('./functions/common_function.php');
session_start();

$username = $_SESSION['user_username']; 
$get_user = "SELECT * FROM `user` WHERE user_username='$username'";
$result = mysqli_query($conn, $get_user);
$row_fetch = mysqli_fetch_assoc($result);
$user_id = $row_fetch['user_id'];
$username = $row_fetch['user_username'];

if(isset($_POST['rating']) && isset($_POST['review'])) {
    $rating = $_POST['rating'];
    $review = mysqli_real_escape_string($conn, $_POST['review']);

    $sql = "INSERT INTO review (user_id, name, content, rating) VALUES ('$user_id', '$username', '$review', '$rating')";

    if(mysqli_query($conn, $sql)) {
        echo "Review submitted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "All fields are required.";
}



// Fetching average rating and total reviews from the database
$query = "SELECT AVG(rating) AS average_rating, COUNT(review_id) AS total_review 
          FROM review"; // Make sure the table name and fields are correct

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

// Calculate progress for star ratings
$total_reviews = $total_five_star_review + $total_four_star_review + $total_three_star_review + $total_two_star_review + $total_one_star_review;

$five_star_progress = $total_reviews > 0 ? ($total_five_star_review / $total_reviews) * 100 : 0;
$four_star_progress = $total_reviews > 0 ? ($total_four_star_review / $total_reviews) * 100 : 0;
$three_star_progress = $total_reviews > 0 ? ($total_three_star_review / $total_reviews) * 100 : 0;
$two_star_progress = $total_reviews > 0 ? ($total_two_star_review / $total_reviews) * 100 : 0;
$one_star_progress = $total_reviews > 0 ? ($total_one_star_review / $total_reviews) * 100 : 0;


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
                </div>
            </div>
        </div>
    </div>
  </div>

  <div id="review_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submit Your Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="rating">Rating</label>
                    <div class="mb-2">
                        <i class="fas fa-star star-light mr-1 submit_star" data-rating="1" id="submit_star_1"></i>
                        <i class="fas fa-star star-light mr-1 submit_star" data-rating="2" id="submit_star_2"></i>
                        <i class="fas fa-star star-light mr-1 submit_star" data-rating="3" id="submit_star_3"></i>
                        <i class="fas fa-star star-light mr-1 submit_star" data-rating="4" id="submit_star_4"></i>
                        <i class="fas fa-star star-light mr-1 submit_star" data-rating="5" id="submit_star_5"></i>
                    </div>
                    <input type="hidden" id="rating" value="0" />
                </div>
                <div class="form-group">
                    <label for="review_text">Review</label>
                    <textarea id="review_text" class="form-control" rows="4" placeholder="Write your review here..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submit_review">Submit Review</button>
            </div>
        </div>
    </div>
</div>

<!-- Button to open the review modal -->
<div class="text-center">
    <button type="button" class="btn btn-warning" id="add_review">Add Review</button>
</div>

<script>
    $(document).on('click', '.submit_star', function() {
        var rating = $(this).data('rating');
        $('#rating').val(rating);
        reset_background();
        
        for (var count = 1; count <= rating; count++) {
            $('#submit_star_' + count).addClass('star-warning');
        }
    });

    $('#submit_review').click(function() {
        var rating = $('#rating').val();
        var review_text = $('#review_text').val();

        if (rating === '0' || review_text === '') {
            alert('Please select a rating and enter your review.');
            return;
        }

        // Ajax call to submit the review
        $.ajax({
            url: 'submit_review.php', // Change this to the correct URL for processing the review
            method: 'POST',
            data: {rating: rating, review: review_text},
            success: function(data) {
                alert('Review submitted successfully.');
                $('#review_modal').modal('hide');
                // Optionally refresh the page or update the review section dynamically
                location.reload(); // Refresh the page to see the new review
            }
        });
    });

    function reset_background() {
        $('.submit_star').addClass('star-light').removeClass('star-warning');
    }
</script>


    <script>
        var rating_data = 0;

        $('#add_review').click(function() {
            $('#review_modal').modal('show');
        });

        $(document).on('mouseenter', '.submit_star', function() {
            var rating = $(this).data('rating');
            reset_background();

            for (var count = 1; count <= rating; count++) {
                $('#submit_star_' + count).addClass('star-warning');
            }
        });

        $(document).on('mouseleave', '.submit_star', function() {
            reset_background();

            for (var count = 1; count <= rating_data; count++) {
                $('#submit_star_' + count).addClass('star-warning');
            }
        });

        $(document).on('click', '.submit_star', function() {
            rating_data = $(this).data('rating');
        });

        function reset_background() {
            for (var count = 1; count <= 5; count++) {
                $('#submit_star_' + count).addClass('star-light').removeClass('star-warning');
            }
        }

        $('#save_review').click(function() {
            
            var user_review = $('#user_review').val();

            if(user_review == '') {
                alert('Please fill all fields');
                return false;
            } else {
                console.log('Sending data:', { rating: rating_data, review: user_review }); // Log data being sent
        $.ajax({
            url: "submitReview.php",
            method: "POST",
            data: { rating: rating_data, review: user_review },
            success: function(data) {
                console.log('Response data:', data); // Log the response to check for errors
                $('#review_modal').modal('hide');
                load_review();
                reset_background();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error); // Log the error
            }
                });
            }
        });

        function load_review() {
            $.ajax({
                url: "fetchReviews.php",
                method: "POST",
                success: function(data) {
                    $('#review_content').html(data);
                }
            });
        }

        $(document).ready(function() {
            load_review();
        });

    </script>
</body>
</html>
