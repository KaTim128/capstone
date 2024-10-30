<?php
// Corrected include file name
include('./database/connection.php');
include('./functions/common_function.php');
session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <title>Review & Rating System in PHP & MySQL using Ajax</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style>
        .star-light {
            color: #ddd;
        }
        .star-warning {
            color: #ffcc00;
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
            <div class="card-header">Sample Product</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4 text-center">
                        <h1 class="text-warning mt-4 mb-4">
                            <b><span id="average_rating">0.0</span> / 5</b>
                        </h1>
                        <div class="mb-3">
                            <i class="fas fa-star star-light mr-1 main_star" id="star_1"></i>
                            <i class="fas fa-star star-light mr-1 main_star" id="star_2"></i>
                            <i class="fas fa-star star-light mr-1 main_star" id="star_3"></i>
                            <i class="fas fa-star star-light mr-1 main_star" id="star_4"></i>
                            <i class="fas fa-star star-light mr-1 main_star" id="star_5"></i>
                        </div>
                        <h3><span id="total_review">0</span> Reviews</h3>
                    </div>
                    <div class="col-sm-4">
                        <p>
                            <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_five_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress"></div>
                            </div>
                        </p>
                        <p>
                            <div class="progress-label-left"><b>4</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_four_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress"></div>
                            </div>               
                        </p>
                        <p>
                            <div class="progress-label-left"><b>3</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_three_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress"></div>
                            </div>               
                        </p>
                        <p>
                            <div class="progress-label-left"><b>2</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_two_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress"></div>
                            </div>               
                        </p>
                        <p>
                            <div class="progress-label-left"><b>1</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_one_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress"></div>
                            </div>               
                        </p>
                    </div>
                    <div class="col-sm-4 text-center">
                        <h3 class="mt-4 mb-3">Write Review Here</h3>
                        <button type="button" name="add_review" id="add_review" class="btn btn-primary">Review</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5" id="review_content"></div>
    </div>

    <div id="review_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Submit Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="text-center mt-2 mb-4">
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
                    </h4>
                    <div class="form-group">
                        <textarea name="user_review" id="user_review" class="form-control" placeholder="Type Review Here"></textarea>
                    </div>
                    <div class="form-group text-center mt-4">
                        <button type="button" class="btn btn-primary" id="save_review">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
            var user_name = $('#user_name').val();
            var user_review = $('#user_review').val();

            if(user_name == '' || user_review == '') {
                alert('Please fill all fields');
                return false;
            } else {
                console.log('Sending data:', { rating: rating_data, name: user_name, review: user_review }); // Log data being sent
        $.ajax({
            url: "submitReview.php",
            method: "POST",
            data: { rating: rating_data, name: user_name, review: user_review },
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
                url: "fetchReview.php",
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