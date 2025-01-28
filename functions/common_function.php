<?php
//including connect file
include(__DIR__ . '/../database/connection.php');

// getting books
function getBooks(){
  global $conn;

  if(!isset($_GET['course'])){
      if(!isset($_GET['stationery'])){
          $select_query = "SELECT * FROM `books` order by rand() limit 0,8";
          $result_query=mysqli_query($conn,$select_query);
          while ($row = mysqli_fetch_assoc($result_query)) {
              $book_id = 'b' . $row['book_id'];
              $book_title = $row['book_title'];
              $author = $row['author'];
              $description = $row['description'];
              $image = $row['image'];
              $price = $row['price'];
              $course_id = $row['course_id'];
              $digital_price = number_format($price / 3, 2);
              echo "<div class=' p1 col-md-3 mb-2'>
              <div class=' p1 card card-background'>
                <img src='admin/bookImages/$image' class=' p1 card-img-top' alt='Book Image'>
                <div class=' p1 card-body'>
                  <h6 class=' p1 card-title'><b>$book_title</b></h6>
                  <p class=' p1 card-text'>RM$digital_price/<span>(Digital)</span></p>
                  <a href='index.php?cart=$book_id' class=' p1 btn btn-style mb-2'>Add to Cart</a>
                  <a href='bookDetails.php?book_id=$book_id' class=' p1 btn btn-style mb-2'>Details</a>
                </div>
              </div>
            </div>";
          }
      }
  }
}


// Updated getUniqueCourses function.
function getUniqueCourses(){
  global $conn;
  if(isset($_GET['course'])){
      $course_id = $_GET['course'];
      $select_query = "SELECT * FROM `books` where course_id=$course_id";
      $result_query = mysqli_query($conn, $select_query);
      $num_of_rows = mysqli_num_rows($result_query);
      if ($num_of_rows == 0) {
        echo "<div class=' p1 alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>There is no stock for this course.</div>";
    }   
      while ($row = mysqli_fetch_assoc($result_query)) {
          $book_id = 'b' . $row['book_id'];
          $book_title = $row['book_title'];
          $author = $row['author'];
          $description = $row['description'];
          $image = $row['image'];
          $price = $row['price'];
          $course_id = $row['course_id'];
          $digital_price = number_format($price / 3, 2);
          echo "<div class=' p1 col-md-3 mb-2'>
                  <div class=' p1 card card-background'>
                    <img src='admin/bookImages/$image' class=' p1 card-img-top' alt='Book Image'>
                    <div class=' p1 card-body'>
                      <h6 class=' p1 card-title'><b>$book_title</b></h6>
                      <p class=' p1 card-text'>RM$digital_price/<span>(Digital)</span></p>
                      <a href='index.php?cart=$book_id' class=' p1 btn btn-style mb-1 me-3'>Add to Cart</a>
                      <a href='bookDetails.php?book_id=$book_id' class=' p1 btn btn-style mb-1'>Details</a>
                    </div>
                  </div>
                </div>";
      }
  }
}

// Updated getUniqueTools function
function getUniqueTools(){
  global $conn;
  if(isset($_GET['stationery'])){
      $stationery_id = $_GET['stationery'];
      $select_query = "SELECT * FROM `tools` where stationery_id=$stationery_id";
      $result_query = mysqli_query($conn, $select_query);
      $num_of_rows = mysqli_num_rows($result_query);
      if($num_of_rows == 0){
        echo "<div class=' p1 alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>There is no stock for this stationary.</div>";
      }
      while ($row = mysqli_fetch_assoc($result_query)) {
          $tool_id = 't' . $row['tool_id'];
          $tool_title = $row['tool_title'];
          $description = $row['description'];
          $image = $row['image'];
          $price = $row['price'];
          $stationery_id = $row['stationery_id'];
          echo "<div class=' p1 col-md-3 mb-2'>
                  <div class=' p1 card card-background'>
                    <img src='admin/toolImages/$image' class=' p1 card-img-top' alt='Tool Image'>
                    <div class=' p1 card-body'>
                      <h5 class=' p1 card-title p1'><b>$tool_title</b></h5>
                      <p class=' p1 card-text p1'>RM$price/-</p>
                      <a href='index.php?cart=$tool_id' class=' p1 p1 btn btn-style mb-1 me-3'>Add to Cart</a>
                      <a href='toolDetails.php?tool_id=$tool_id' class=' p1 p1 btn btn-style mb-1'>Details</a>
                    </div>
                  </div>
                </div>";
      }
  }
}


//display side navbar courses
function getCourses(){
    global $conn;
      $select_courses="Select * from `courses`";
      $result_courses=mysqli_query($conn,$select_courses);
      while($row_data=mysqli_fetch_assoc($result_courses)){
        $course_title=$row_data['course_title'];
        $course_id=$row_data['course_id'];
        echo "<li class=' p1 nav-item p1'>
        <a href='index.php?course=$course_id' class=' p1 p1 nav-link nav-zoom text-dark'><b>$course_title</b></a>
        </li>";
      }
    }

    
//display side navbar stationaries
function getStationeries(){
    global $conn;
      $select_stationaries="Select * from `stationery`";
      $result_stationaries=mysqli_query($conn,$select_stationaries);
      while($row_data=mysqli_fetch_assoc($result_stationaries)){
        $stationery_title=$row_data['stationery_title'];
        $stationery_id=$row_data['stationery_id'];
        echo "<li class=' p1 p1 nav-item'>
        <a href='index.php?stationery=$stationery_id' class=' p1 p1 nav-link nav-zoom text-dark'><b>$stationery_title</b></a>
        </li>";
      }
    }

    function getFooter() {
      global $conn;
      echo "
          <style>
              /* General Styles */
              body {
                  display: flex;
                  flex-direction: column;
                  min-height: 100vh;
              }
              .main-content {
                  flex: 1;
              }
              .footer {
                  margin-top: auto;
                  background-color: #013220;
                  padding: 1rem;
                  text-align: center;
                  width: 100%;
              }
  
              /* Horizontal Footer (Desktop) */
          .footer-horizontal {
              display: flex;
              justify-content: space-between;
              align-items: center;
              padding: 1rem;
              flex-wrap: wrap;
              visibility: visible; /* Ensure it's visible on desktop */
          }

          /* Vertical Footer (Mobile) */
          .footer-vertical {
              display: none;
              flex-direction: column;
              text-align: center;
              visibility: hidden; /* Hidden by default */
          }

          /* Mobile Styles */
          @media (max-width: 991px) {
              .footer-horizontal {
                  display: none !important; /* Hide desktop footer */
                  visibility: hidden;
              }
              .footer-vertical {
                  display: flex !important; /* Show mobile footer */
                  visibility: visible;
              }
          }
          </style>
  
          <footer class='p1 footer'>
              <!-- Desktop Footer -->
              <div class='footer-horizontal d-flex flex-column align-items-center text-light'>
                  <p class='mb-0'>Website, Designed by Ho Ka Tim © 2024.</p>
              </div>
  
              <!-- Mobile Footer -->
              <div class='footer-vertical text-light mb-3'>
                  <ul class='navbar-nav'>
                      <li class='nav-item'>
                          <a class='nav-link text-light' href='../index.php'>Products</a>
                      </li>
                      <li class='nav-item'>
                          <a class='nav-link text-light' href='../users/wishlist.php'>Wishlist</a>
                      </li>";
  
                      // PHP to check if user is logged in
                      if (isset($_SESSION['user_username'])) {
                          echo "
                          <li class='nav-item'>
                              <a class='nav-link nav-zoom text-light' href='../users/profile.php'>My Account</a>
                          </li>";
                      } else {
                          echo "
                          <li class='nav-item'>
                              <a class='nav-link nav-zoom text-light' href='../users/user_login.php'>Login</a>
                          </li>";
                      }
  
                      echo "
                      <li class='nav-item'>
                          <a class='nav-link nav-zoom text-light' href='../contact_page.php'>Contact</a>
                      </li>
                      <li class='nav-item'>
                          <a class='nav-link nav-zoom text-light' href='../cart.php'>Cart
                              <sup><i class='fa fa-shopping-cart' aria-hidden='true'></i>"; 
                              cartItem(); 
                              echo "</sup>
                          </a>
                      </li>
                      <li class='nav-item'>
                          <a class='nav-link text-light' href='#'>Total Price: RM"; 
                          totalCartPrice(); 
                          echo "</a>
                      </li>
                  </ul>
  
                  <!-- Search form -->
                  <form class='p1 form-inline my-2 my-lg-0 d-flex justify-content-center' action='../searchProduct.php' method='get'>
                      <input class='p1 form-control mr-sm-3' style='width: 90%;' type='search' placeholder='Search' aria-label='Search' name='search_data'>
                      <button class='p1 btn btn-outline-light my-2 my-sm-0 mt-3' value='Search' type='submit' name='search_data_product'>Search</button>
                  </form>
              </div>
          </footer>
      ";
  }
  

function searchProducts() {
  global $conn;

  if (isset($_GET['search_data_product'])) {
      $search_data_value = $_GET['search_data'];

      // Search both books and tools using UNION to combine results
      $search_query = "
          (SELECT 'book' AS type, book_id AS id, book_title AS title, price, image 
           FROM `books` WHERE LOWER(keyword) LIKE LOWER('%$search_data_value%'))
          UNION
          (SELECT 'tool' AS type, tool_id AS id, tool_title AS title, price, image 
           FROM `tools` WHERE LOWER(keyword) LIKE LOWER('%$search_data_value%'))
      ";

      $result_query = mysqli_query($conn, $search_query);
      $num_of_rows = mysqli_num_rows($result_query);

      // If no products are found
      if ($num_of_rows == 0) {
          echo "<div class=' p1 alert alert-warning text-center my-4 p1' style='margin: 0 auto; width: fit-content;'>Product searched is not found.</div>";
      }

      // Display results from both books and tools
      while ($row = mysqli_fetch_assoc($result_query)) {
          $id = $row['id'];
          $title = $row['title'];
          $price = $row['price'];
          $image = $row['image'];
          $type = $row['type']; // Either 'book' or 'tool'
          $digital_price = number_format($price / 3, 2);
          // Depending on the product type, create the correct URL for details
          $details_url = $type === 'book' ? "bookDetails.php?book_id=b$id" : "toolDetails.php?tool_id=t$id";
          $cart_url = $type === 'book' ? "index.php?cart=b$id" : "index.php?cart=t$id";

          echo "<div class=' p1 col-md-3 mb-2'>
                  <div class=' p1 card card-background'>
                    <img src='admin/{$type}Images/$image' class=' p1 card-img-top' alt='Product Image'>
                    <div class=' p1 card-body'>
                      <h6 class=' p1 card-title p1'><b>$title</b></h6>
                      <p class=' p1 card-text'>RM$digital_price/<span>(Digital)</span></p>
                      <a href='$cart_url' class=' p1 p1 btn btn-style mb-1'>Add to Cart</a>
                      <a href='$details_url' class=' p1 p1 btn btn-style mb-1'>Details</a>
                    </div>
                  </div>
                </div>";
      }
  }
}


function viewBookDetails() {
  global $conn;

  if (isset($_GET['book_id'])) {
      if (!isset($_GET['course']) && !isset($_GET['stationery'])) {

          // Handle book_id with prefix "b"
          $book_id = $_GET['book_id'];

          // Remove prefix "b" to query the database
          $actual_book_id = str_replace('b', '', $book_id);

          // Fetch book details
          $select_query = "SELECT * FROM `books` WHERE book_id='$actual_book_id'";
          $result_query = mysqli_query($conn, $select_query);

          while ($row = mysqli_fetch_assoc($result_query)) {
              $book_id_with_prefix = 'b' . $row['book_id']; // Use this for the wishlist
              $book_title = $row['book_title'];
              $author = $row['author'];
              $description = $row['description'];
              $image = $row['image'];
              $price = $row['price'];

              $digital_price = number_format($price / 3, 2);

              // Prepare the correct book_id for the reviews button
              $book_id_for_reviews = $row['book_id']; // Use the actual book_id from the database

              echo "<div class=' p1 col-md- mb-2'>
        <div class=' p1 card mt-4'>
          <img src='admin/bookImages/$image' class=' p1 ' style='width:150px; height:190px;' alt='Book Image'>
        </div>
      </div>
      
      <div class=' p1 col-md-8'>
        <div class=' p1 row'>
          <div class=' p1 col-md-12'>
            <h3 class=' p1 text-dark mb-4 mt-4' style='overflow:hidden'><b>$book_title</b></h3>
            <div class=' p1 mb-4 d-flex justify-content-between align-items-center'>
              <h5 class=' p1 mb-0' style='overflow:hidden'>Author: $author</h5>
              <div>
                <h6 class=' p1 mb-0' style='overflow:hidden'>RM$price <span>(Printed)</span></h6>
                <h6 class=' p1 mb-0' style='overflow:hidden'>RM$digital_price <span>(Digital)</span></h6>
              </div>
            </div>
            <h6 class=' p1 mb-5' style='overflow:hidden'>$description</h6>
            <!-- Desktop Layout -->
            <div class='d-lg-flex align-items-center d-none'>
              <a href='index.php' class='p1 btn btn-details me-2 mb-3 mx-2 btn-style'>Back</a>
              <a href='index.php?cart=$book_id' class='p1 btn btn-details me-2 mb-3 mx-2 btn-style'>Add to Cart</a>
              <form method='post' action='users/wishlist.php' class='p1 me-2 mb-3 mx-2' style='overflow:hidden'>
                <input type='hidden' name='book_id' value='$book_id_with_prefix'>
                <input type='hidden' name='book_title' value='$book_title'>
                <input type='hidden' name='book_image' value='$image'>
                <input type='hidden' name='book_price' value='$price'>
                <input type='submit' class='p1 btn btn-details btn-style' style='overflow:hidden' name='add_to_wishlist' value='Add to Wishlist'>
              </form>
              <a href='reviews.php?book_id=b$book_id_for_reviews' class='p1 btn btn-details mb-3 ml-1 btn-style'>Reviews</a>
            </div>

            <!-- Mobile Layout -->
            <div class='d-lg-none row gy-2'>
              <div class='col-12'>
                <a href='index.php' class='btn btn-details btn-style w-50 mb-2'>Back</a>
              </div>
              <div class='col-12'>
                <a href='index.php?cart=$book_id' class='btn btn-details btn-style w-50 mb-2'>Add to Cart</a>
              </div>
              <div class='col-12'>
                <form method='post' action='users/wishlist.php' class='w-50 mb-2'>
                  <input type='hidden' name='book_id' value='$book_id_with_prefix'>
                  <input type='hidden' name='book_title' value='$book_title'>
                  <input type='hidden' name='book_image' value='$image'>
                  <input type='hidden' name='book_price' value='$price'>
                  <input type='submit' class='btn btn-details btn-style w-100' name='add_to_wishlist' value='Add to Wishlist'>
                </form>
              </div>
              <div class='col-12'>
                <a href='reviews.php?book_id=b$book_id_for_reviews' class='btn btn-details btn-style w-50 mb-4'>Reviews</a>
              </div>
            </div>
          </div>
        </div>
      </div>";
          }
      }
  }
}

function viewToolDetails() {
  global $conn;

  if (isset($_GET['tool_id'])) {
      if (!isset($_GET['books'])) {         
          // Handle tool_id with prefix "t"
          $tool_id = $_GET['tool_id'];

          // Remove prefix "t" to query the database
          $actual_tool_id = str_replace('t', '', $tool_id);

          // Fetch tool details
          $select_query = "SELECT * FROM `tools` WHERE tool_id='$actual_tool_id'";
          $result_query = mysqli_query($conn, $select_query);

          while ($row = mysqli_fetch_assoc($result_query)) {
              $tool_id_with_prefix = 't' . $row['tool_id']; // Re-adding the prefix for display and links
              $tool_title = $row['tool_title'];
              $description = $row['description'];
              $image = $row['image'];
              $price = $row['price'];
              // Prepare the correct tool_id for the reviews button
              $tool_id_for_reviews = $row['tool_id']; // Use the actual tool_id from the database

              echo "<div class='p1 col-md-3 mb-2'>
        <div class='p1 card mt-4'>
          <img src='admin/toolImages/$image' class='p1' style='width:150px; height:190px;' alt='Tool Image'>
        </div>
    </div>
    
    <div class='p1 col-md-8'>
        <div class='p1 row'>
            <div class='p1 col-md-12'>
                <h3 class='p1 text-dark mb-5 mt-4 text'><b>$tool_title</b></h3>
                <h6 class='p1 mr-5 mb-5 text'>Price: RM$price/-</h6>
                <h6 class='p1 mb-5' style='overflow:hidden'>$description</h6>

                <!-- Desktop Layout -->
                <div class='d-lg-flex align-items-center d-none'>
                    <a href='index.php' class='p1 btn btn-details me-2 mb-3 mr-2 btn-style'>Back</a>
                    <a href='index.php?cart=$tool_id' class='p1 btn btn-details me-2 mb-3 mr-2 ml-1 btn-style'>Add to Cart</a>
                    <form method='post' action='users/wishlist.php' class='p1 me-2 mb-3 ml-1' style='overflow:hidden'>
                        <input type='hidden' name='tool_id' value='$tool_id_with_prefix'>
                        <input type='hidden' name='tool_title' value='$tool_title'>
                        <input type='hidden' name='tool_image' value='$image'>
                        <input type='hidden' name='tool_price' value='$price'>
                        <input type='submit' class='p1 btn btn-details btn-style' style='overflow:hidden' name='add_to_wishlist' value='Add to Wishlist'>
                    </form>
                    <a href='reviews.php?tool_id=t$tool_id_for_reviews' class='p1 btn btn-details mb-3 ml-1 btn-style'>Reviews</a>
                </div>

                <!-- Mobile Layout -->
                <div class='d-lg-none row gy-2'>
                    <div class='col-12'>
                        <a href='index.php' class='btn btn-details btn-style w-50 mb-2'>Back</a>
                    </div>
                    <div class='col-12'>
                        <a href='index.php?cart=$tool_id' class='btn btn-details btn-style w-50 mb-2'>Add to Cart</a>
                    </div>
                    <div class='col-12'>
                        <form method='post' action='users/wishlist.php' class='w-50 mb-2'>
                            <input type='hidden' name='tool_id' value='$tool_id_with_prefix'>
                            <input type='hidden' name='tool_title' value='$tool_title'>
                            <input type='hidden' name='tool_image' value='$image'>
                            <input type='hidden' name='tool_price' value='$price'>
                            <input type='submit' class='btn btn-details btn-style w-100' name='add_to_wishlist' value='Add to Wishlist'>
                        </form>
                    </div>
                    <div class='col-12'>
                        <a href='reviews.php?tool_id=t$tool_id_for_reviews' class='btn btn-details btn-style w-50 mb-4'>Reviews</a>
                    </div>
                </div>
            </div>
        </div>
    </div>";
          }
      }
  }
}


//get ip function
function getIPAddress() {  
  //whether ip is from the share internet  
   if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
              $ip = $_SERVER['HTTP_CLIENT_IP'];  
      }  
  //whether ip is from the proxy  
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
              $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
   }  
//whether ip is from the remote address  
  else{  
           $ip = $_SERVER['REMOTE_ADDR'];  
   }  
   return $ip;  
} 


function manageCart() {
  global $conn;

  // Check if user is logged in and set user_id accordingly
  $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; // Set to 0 for guests

  // Updating guest cart items to the logged-in user ID when user logs in
  if ($user_id > 0) {
      // Move guest cart items to user cart
      $update_query = "UPDATE cart SET user_id = '$user_id' WHERE user_id = 0";
      mysqli_query($conn, $update_query);

      // After updating, ensure no duplicates are present
      $deduplication_query = "DELETE c1 FROM cart c1 
                              INNER JOIN cart c2 
                              WHERE c1.cart_id > c2.cart_id 
                              AND ((c1.book_id = c2.book_id AND c1.user_id = '$user_id') 
                              OR (c1.tool_id = c2.tool_id AND c1.user_id = '$user_id'))";
      mysqli_query($conn, $deduplication_query);
  }

  // Adding items to the cart
  if (isset($_POST['add_to_cart'])) {
      $product_id = $_POST['product_id']; // Assuming you are passing the product ID

      // Determine if the product is a book or a tool
      $prefix = substr($product_id, 0, 1); // getting the prefix b or t
      $id = intval(substr($product_id, 1)); //getting the id

      // Check for existing item in the cart based on user_id and product type
      $existing_query = "";
      if ($prefix == 'b') {
          $existing_query = "SELECT * FROM cart WHERE user_id='$user_id' AND book_id='$id'";
      } elseif ($prefix == 't') {
          $existing_query = "SELECT * FROM cart WHERE user_id='$user_id' AND tool_id='$id'";
      }

      // Execute the existing query
      $result = mysqli_query($conn, $existing_query);

      // Prevent duplication in the user's cart
      if (mysqli_num_rows($result) > 0) {
          $_SESSION['cart_alert'] = ($prefix == 'b') ? 'This book is already in your cart!' : 
          'This tool is already in your cart!';
      } else {
          // Adding the item to the cart in the database
          if ($prefix == 'b') {
              $insert_query = "INSERT INTO cart (book_id, user_id) VALUES ('$id', '$user_id')";
          } elseif ($prefix == 't') {
              $insert_query = "INSERT INTO cart (tool_id, user_id) VALUES ('$id', '$user_id')";
          }

          // Execute the insert query
          if (mysqli_query($conn, $insert_query)) {
              $_SESSION['cart_alert'] = 'Your item has been added to the cart!';
          } else {
              $_SESSION['cart_alert'] = 'Failed to add item to cart.';
          }
      }

      // Refresh the page after adding to cart
      header("Location: " . $_SERVER['PHP_SELF']);
      exit(); // Make sure to exit after the redirect
  }

  // Handle cart item retrieval or addition based on GET parameters
  if (isset($_GET['cart'])) {
      $ip = getIPAddress(); // Use IP address if required for other parts of the system
      $get_product_id = $_GET['cart'];
      $booktype = isset($_POST['booktype']) ? $_POST['booktype'] : 'digital';

      // Determine if the product is a book or a tool
      $prefix = substr($get_product_id, 0, 1);
      $id = intval(substr($get_product_id, 1));

      // Check if the item already exists in the cart for this user_id
      $result_query = null;

      if ($prefix == 'b') {
          $result_query = mysqli_query($conn, "SELECT * FROM cart 
          WHERE user_id='$user_id' AND book_id='$id'");
      } elseif ($prefix == 't') {
          $result_query = mysqli_query($conn, "SELECT * FROM cart 
          WHERE user_id='$user_id' AND tool_id='$id'");
      }

      // Initialize alert message variable
      $alertMessage = '';
      // Checking if the item exists and set the alert message accordingly
      if ($prefix == 'b' && mysqli_num_rows($result_query) > 0) {
          $alertMessage = 'This book is already in your cart!';
      } elseif ($prefix == 't' && mysqli_num_rows($result_query) > 0) {
          $alertMessage = 'This tool is already in your cart!';
      } else {
          // Insert the item into the cart with user_id, default or selected booktype, and quantity
          $insert_query = "";
          if ($prefix == 'b') {
              $insert_query = "INSERT INTO cart (book_id, user_id, ip_address, 
              quantity, booktype) VALUES ('$id', '$user_id', '$ip', 1, '$booktype')";
          } elseif ($prefix == 't') {
              $insert_query = "INSERT INTO cart (tool_id, user_id, ip_address,
               quantity) VALUES ('$id', '$user_id', '$ip', 1)";
          }
          // Execute the query and set alert message if successful
          if (!empty($insert_query)) {
              mysqli_query($conn, $insert_query);
              $alertMessage = 'Item added to cart!';
          } else {
              $alertMessage = 'Failed to add item to cart.';
          }
      }

      if ($alertMessage) {
          $_SESSION['cart_alert'] = $alertMessage;
          // Refresh the page to show the alert
          header("Location: " . $_SERVER['PHP_SELF']);
          exit();
      }
  }
}

// On the page load, display the alert message if it exists
if (isset($_SESSION['cart_alert'])) {
  echo "<div class=' p1 alert'>" . $_SESSION['cart_alert'] . "</div>";
  unset($_SESSION['cart_alert']); // Clear the alert after displaying it
}



// Function to display alert messages from the session
function displayAlert() {
    if (isset($_SESSION['alert'])) {
        echo "<script>alert('" . $_SESSION['alert'] . "');</script>";
        unset($_SESSION['alert']); // Clear the alert after displaying it
    }
}


// Function to get cart item numbers
function cartItem() {
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    global $conn;
    $ip = getIPAddress(); 
    $select_query = "SELECT * FROM `cart` WHERE ip_address='$ip' AND user_id = '$user_id'";
    $result_query = mysqli_query($conn, $select_query);
    $count_cart_items = mysqli_num_rows($result_query);
    echo $count_cart_items;
}


function totalCartPrice() {
  global $conn;
  $get_ip_add = getIPAddress();
  $total_book_price = 0;
  $total_tool_price = 0;

  // Run the query to get cart items based on IP address
  $cart_query = "SELECT * FROM `cart` WHERE ip_address='$get_ip_add'";
  $result = mysqli_query($conn, $cart_query);

  // Loop through each item in the cart
  while ($row = mysqli_fetch_array($result)) {
      $book_id = $row['book_id'];
      $tool_id = $row['tool_id'];
      $quantity = $row['quantity'];  // Get the quantity of the item
      $booktype = $row['booktype'];  // Get the booktype (digital or printed)

      // Get the price of the book from the books table if book_id is present
      if (!empty($book_id)) {
          $select_books = "SELECT price FROM `books` WHERE book_id='$book_id'";
          $result_books = mysqli_query($conn, $select_books);

          if ($row_book_price = mysqli_fetch_array($result_books)) {
              $book_price = $row_book_price['price'];
              
              // If the book is digital, reduce the price by a factor of 3
              if ($booktype === 'digital') {
                  $book_price /= 3;
              }

              // Add the total book price based on quantity
              $total_book_price += $book_price * $quantity;
          }
      }

      // Get the price of the tool from the tools table if tool_id is present
      if (!empty($tool_id)) {
          $select_tools = "SELECT price FROM `tools` WHERE tool_id='$tool_id'";
          $result_tools = mysqli_query($conn, $select_tools);

          if ($row_tool_price = mysqli_fetch_array($result_tools)) {
              $tool_price = $row_tool_price['price'];
              // Add the total tool price based on quantity
              $total_tool_price += $tool_price * $quantity;
          }
      }
  }

  // Total price calculation
  $total_price = $total_book_price + $total_tool_price;     
  echo number_format($total_price, 2);  // Display the total price
}

  
  function orderDetails(){
    global $conn;
    $username = $_SESSION['user_username'];
    $get_details = "SELECT * FROM `user` WHERE user_username='$username'";
    $result_query = mysqli_query($conn, $get_details);
    
    while ($row_query = mysqli_fetch_array($result_query)) {
        $user_id = $row_query['user_id'];
        
        if (isset($_GET['edit_account'])) {
            include('edit_acc.php');
        } elseif (isset($_GET['my_orders'])) {
            include('pending_orders.php');
            return;
        }elseif (isset($_GET['paid_orders'])) {
          include('paid_orders.php');
          return;
      } 
        elseif (isset($_GET['delete_account'])) {
          include('delete_acc.php');
        } else {
            // Query for pending orders only if neither edit nor my orders are selected
            $get_orders = "SELECT * FROM `orders` WHERE user_id = $user_id AND order_status = 'pending'";
            $result_orders_query = mysqli_query($conn, $get_orders);
            $row_count = mysqli_num_rows($result_orders_query);
            if ($row_count > 0) {
                echo "<h3 class=' p1 text-center mt-5' style='margin-top:100px; overflow:hidden'>You have <span class=' p1 text-success'>$row_count </span> pending orders</h3>";
                echo "<p class=' p1 text-center'><a href='profile.php?my_orders' class=' p1 text-dark'>Order Details</a></p>";          
              } else {
                echo "<h3 class=' p1 text-center mt-5' style='margin-top:100px; overflow:hidden'>You have 0 pending orders</h3>";
                echo "<p class=' p1 text-center'><a href='../index.php' class=' p1 text-dark'>Explore products</a></p>";
            }
        }
    }
}
?>