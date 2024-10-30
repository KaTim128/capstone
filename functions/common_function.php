<?php
//including connect file
include(__DIR__ . '/../database/connection.php');

// getting books
function getBooks(){
  global $conn;

  //when course or tool id is not present in URL
  if(!isset($_GET['course'])){
      if(!isset($_GET['stationery'])){
          $select_query = "SELECT * FROM `books` order by rand() limit 0,9";
          $result_query=mysqli_query($conn,$select_query);
          while ($row = mysqli_fetch_assoc($result_query)) {
              $book_id = 'b' . $row['book_id'];
              $book_title = $row['book_title'];
              $author = $row['author'];
              $description = $row['description'];
              $image = $row['image'];
              $price = $row['price'];
              $course_id = $row['course_id'];
              echo "<div class='col-md-4 mb-2'>
                  <div class='card'>
                    <img src='admin/bookImages/$image' class='card-img-top' alt='Book Image'>
                    <div class='card-body'>
                      <h5 class='card-title' >$book_title</h5>
                      <p class='card-text'><b>RM$price/-</b></p>
                      <a href='index.php?cart=$book_id' class='btn btn-info mb-1'>Add to Cart</a>
                      <a href='bookDetails.php?book_id=$book_id' class='btn btn-secondary mb-1'>Details</a>
                    </div>
                  </div>
                </div>";
          }
      }
  }
}


// getting books and tools
function getBooksAndTools() {
  global $conn;

  // Query to select books
  $select_books_query = "SELECT * FROM `books` ORDER BY RAND() LIMIT 0, 9";
  $result_books_query = mysqli_query($conn, $select_books_query);

  // Displaying books
  while ($row = mysqli_fetch_assoc($result_books_query)) {
      $book_id = 'b' . $row['book_id'];
      $book_title = $row['book_title'];
      $author = $row['author'];
      $description = $row['description'];
      $image = $row['image'];
      $price = $row['price'];
      $course_id = $row['course_id'];
      
      echo "<div class='col-md-4 mb-2'>
              <div class='card'>
                  <img src='admin/bookImages/$image' class='card-img-top' alt='Book Image'>
                  <div class='card-body'>
                      <h5 class='card-title'>$book_title</h5>
                      <p class='card-text'><b>RM$price/-</b></p>
                      <a href='index.php?cart=$book_id' class='btn btn-info mb-1'>Add to Cart</a>
                      <a href='bookDetails.php?book_id=$book_id' class='btn btn-secondary mb-1'>Details</a>
                  </div>
              </div>
            </div>";
  }

  $select_tools_query = "SELECT * FROM `tools` ORDER BY RAND() LIMIT 0, 9";
  $result_tools_query = mysqli_query($conn, $select_tools_query);

  // Displaying tools
  while ($row = mysqli_fetch_assoc($result_tools_query)) {
      $tool_id = 't' . $row['tool_id'];
      $tool_title = $row['tool_title'];
      $tool_description = $row['description'];
      $tool_image = $row['image'];
      $tool_price = $row['price'];

      echo "<div class='col-md-4 mb-2'>
              <div class='card'>
                  <img src='admin/toolImages/$tool_image' class='card-img-top' alt='Tool Image'>
                  <div class='card-body'>
                      <h5 class='card-title'>$tool_title</h5>
                      <p class='card-text'><b>RM$tool_price/-</b></p>
                      <a href='index.php?cart=$tool_id' class='btn btn-info mb-1'>Add to Cart</a>
                      <a href='toolDetails.php?tool_id=$tool_id' class='btn btn-secondary mb-1'>Details</a>
                  </div>
              </div>
            </div>";
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
        echo "<div class='alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>There is no stock for this course.</div>";
    }
    
      while ($row = mysqli_fetch_assoc($result_query)) {
          $book_id = 'b' . $row['book_id'];
          $book_title = $row['book_title'];
          $author = $row['author'];
          $description = $row['description'];
          $image = $row['image'];
          $price = $row['price'];
          $course_id = $row['course_id'];
          echo "<div class='col-md-4 mb-2'>
                  <div class='card'>
                    <img src='admin/bookImages/$image' class='card-img-top' alt='Book Image'>
                    <div class='card-body'>
                      <h5 class='card-title'>$book_title</h5>
                      <p class='card-text'><b>RM$price/-</b></p>
                      <a href='index.php?cart=$book_id' class='btn btn-info mb-1'>Add to Cart</a>
                      <a href='bookDetails.php?book_id=$book_id' class='btn btn-secondary mb-1'>Details</a>
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
        echo "<div class='alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>There is no stock for this stationary.</div>";
      }
      while ($row = mysqli_fetch_assoc($result_query)) {
          $tool_id = 't' . $row['tool_id'];
          $tool_title = $row['tool_title'];
          $description = $row['description'];
          $image = $row['image'];
          $price = $row['price'];
          $stationery_id = $row['stationery_id'];
          echo "<div class='col-md-4 mb-2'>
                  <div class='card'>
                    <img src='admin/toolImages/$image' class='card-img-top' alt='Tool Image'>
                    <div class='card-body'>
                      <h5 class='card-title '>$tool_title</h5>
                      <p class='card-text'><b>RM$price/-</b></p>
                      <a href='index.php?cart=$tool_id' class='btn btn-info mb-1'>Add to Cart</a>
                      <a href='toolDetails.php?tool_id=$tool_id' class='btn btn-secondary mb-1'>Details</a>
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
        echo "<li class='nav-item'>
        <a href='index.php?course=$course_id' class='nav-link text-light'>$course_title</a>
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
        echo "<li class='nav-item'>
        <a href='index.php?stationery=$stationery_id' class='nav-link text-light'>$stationery_title</a>
        </li>";
      }
    }

    function getFooter(){
      global $conn;
      echo "
        <style>
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
            background-color: #17a2b8;
            padding: 1rem;
            text-align: center;
            width:100%;
          }
        </style>

        <div class='footer'>
          <p>Website, Designed by Ho Ka Tim © 2024.</p>
        </div>";
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
          echo "<div class='alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>Product searched is not found.</div>";
      }

      // Display results from both books and tools
      while ($row = mysqli_fetch_assoc($result_query)) {
          $id = $row['id'];
          $title = $row['title'];
          $price = $row['price'];
          $image = $row['image'];
          $type = $row['type']; // Either 'book' or 'tool'

          // Depending on the product type, create the correct URL for details
          $details_url = $type === 'book' ? "bookDetails.php?book_id=b$id" : "toolDetails.php?tool_id=t$id";
          $cart_url = $type === 'book' ? "index.php?cart=b$id" : "index.php?cart=t$id";

          echo "<div class='col-md-4 mb-2'>
                  <div class='card'>
                    <img src='admin/{$type}Images/$image' class='card-img-top' alt='Product Image'>
                    <div class='card-body'>
                      <h5 class='card-title'>$title</h5>
                      <p class='card-text'><b>RM$price/-</b></p>
                      <a href='$cart_url' class='btn btn-info mb-1'>Add to Cart</a>
                      <a href='$details_url' class='btn btn-secondary mb-1'>Details</a>
                    </div>
                  </div>
                </div>";
      }
  }
}


//view details function
function viewBookDetails(){
  global $conn;

  if (isset($_GET['book_id'])) {
    if (!isset($_GET['course']) && !isset($_GET['stationery'])) {
      
      // Handle book_id with prefix "b"
      $book_id = $_GET['book_id'];

      // Remove prefix "b" to query the database (assuming the database doesn't store the prefix)
      $actual_book_id = str_replace('b', '', $book_id);

      // Fetch book details
      $select_query = "SELECT * FROM `books` WHERE book_id='$actual_book_id'";
      $result_query = mysqli_query($conn, $select_query);

      while ($row = mysqli_fetch_assoc($result_query)) {
        $book_id_with_prefix = 'b' . $row['book_id'];
        $book_title = $row['book_title'];
        $author = $row['author'];
        $description = $row['description'];
        $image = $row['image'];
        $price = $row['price'];
        $course_id = $row['course_id'];
        

      echo "<div class='col-md-4 mb-2'>
            <div class='card mt-4'>
              <img src='admin/bookImages/$image' class='' alt='Book Image'>
            </div>
          </div>
          
          <div class='col-md-8'>
         <div class='row'>
            <div class='col-md-12'>
                <h2 class='text-info mb-4 mt-4 text'>$book_title</h2>
                <div class='d-flex justify-content-between mb-4'>
                  <h5 class='mb-0 text'>Author: $author</h5>
                  <h5 class='mr-5 mb-4 text'>Price: RM$price/-</h5>
                </div>
                <h6 class='mb-5'>$description</h6>
                <div class='d-flex'>
                  <a href='index.php' class='btn btn-info me-2 mr-2 mb-3'>Back</a>
                  <a href='index.php?cart=$book_id' class='btn btn-info me-2 mr-2 mb-3'>Add to Cart</a>
                  <form method='post' action='users/wishlist.php' class='me-2 mr-2 mb-3'>
                                      <input type='hidden' name='book_id' value='$book_id_with_prefix'>
                                      <input type='hidden' name='book_title' value='$book_title'>
                                      <input type='hidden' name='book_image' value='$image'>
                                      <input type='hidden' name='book_price' value='$price'>
                                      <input type='submit' class='btn btn-info' name='add_to_wishlist' value='Add to Wishlist'>
                                  </form>
                                  <a href='reviews.php?book_id=$book_id' class='btn btn-info mb-3'>Reviews</a>
                                </div>
                            </div>
                        </div>
                    </div>";
            }
        }
    }
}


    function viewToolDetails(){
      global $conn;
    
      if (isset($_GET['tool_id'])) {
        if (!isset($_GET['books'])) {
          
          // Handle tool_id with prefix "t"
          $tool_id = $_GET['tool_id'];
    
          // Remove prefix "t" to query the database (assuming the database doesn't store the prefix)
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
            $stationery_id = $row['stationery_id'];

      echo "<div class='col-md-4 mb-2'>
            <div class='card'>
              <img src='admin/toolImages/$image' class='' alt='Tool Image'>
            </div>
          </div>
          
          <div class='col-md-8'>
        <!-- related images -->
         <div class='row mt-4'>
            <div class='col-md-12'>
                <h2 class='text-info mb-4 mt-4 text'>$tool_title</h2>
                <h5 class='mr-5 mb-5 text'>Price: RM$price/-</h5>
                <h6 class='mb-5'>$description</h6>
                <div class='d-flex'>
                  <a href='index.php' class='btn btn-info me-2 mr-2 mb-3'>Back</a>
                  <a href='index.php?cart=$tool_id' class='btn btn-info me-2 mr-2 mb-3'>Add to Cart</a>
                                <form method='post' action='users/wishlist.php' class='me-2 mr-2 mb-3'>
                                    <input type='hidden' name='tool_id' value='$tool_id_with_prefix'>
                                    <input type='hidden' name='book_title' value='$tool_title'>
                                    <input type='hidden' name='book_image' value='$image'>
                                    <input type='hidden' name='book_price' value='$price'>
                                    <input type='submit' class='btn btn-info' name='add_to_wishlist' value='Add to Wishlist'>
                                </form>
                                <a href='reviews.php?tool_id=$tool_id' class='btn btn-info mb-3'>Reviews</a>
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
  if (isset($_GET['cart'])) {
      $ip = getIPAddress();
      $get_product_id = $_GET['cart'];
      $booktype = isset($_POST['booktype']) ? $_POST['booktype'] : 'digital';

      $prefix = substr($get_product_id, 0, 1);
      $id = intval(substr($get_product_id, 1));

      // Initialize query result variables
      $result_query_b = null;
      $result_query_t = null;

      // Check if the item already exists in the cart
      if ($prefix == 'b') {
          $result_query_b = mysqli_query($conn, "SELECT * FROM `cart` WHERE ip_address='$ip' AND book_id='$id'");
      } elseif ($prefix == 't') {
          $result_query_t = mysqli_query($conn, "SELECT * FROM `cart` WHERE ip_address='$ip' AND tool_id='$id'");
      }

      // Initialize alert message variable
      $alertMessage = '';

      // Check if the item exists and set the alert message accordingly
      if ($prefix == 'b' && mysqli_num_rows($result_query_b) > 0) {
          $alertMessage = 'This book is already in your cart!';
      } elseif ($prefix == 't' && mysqli_num_rows($result_query_t) > 0) {
          $alertMessage = 'This tool is already in your cart!';
      } else {
          // Insert the item into the cart with default or selected booktype
          $insert_query = "";

          if ($prefix == 'b') {
              // Insert books with booktype
              $insert_query = "INSERT INTO `cart` (book_id, ip_address, quantity, booktype) VALUES ('$id', '$ip', 1, '$booktype')";
          } elseif ($prefix == 't') {
              // Insert tools without booktype
              $insert_query = "INSERT INTO `cart` (tool_id, ip_address, quantity) VALUES ('$id', '$ip', 1)";
          }

          // Execute the query and set alert message if successful
          if (!empty($insert_query)) {
              mysqli_query($conn, $insert_query);
              $alertMessage = 'Item added to cart!';
          } else {
              $alertMessage = 'Failed to add item to cart.';
          }
      }

      // Store the alert message in the session
      $_SESSION['alert'] = $alertMessage;

      // Redirect to the previous page
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit();
  }
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
    global $conn;
    $ip = getIPAddress(); 
    $select_query = "SELECT * FROM `cart` WHERE ip_address='$ip'";
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
  
      // Get the price of the book from the books table if book_id is present
      if (!empty($book_id)) {
        $select_books = "SELECT price FROM `books` WHERE book_id='$book_id'";
        $result_books = mysqli_query($conn, $select_books);
        while ($row_book_price = mysqli_fetch_array($result_books)) {
          $book_price = $row_book_price['price'];
          $total_book_price += $book_price; // Add price to total
        }
      }
  
      // Get the price of the tool from the tools table if tool_id is present
      if (!empty($tool_id)) {
        $select_tools = "SELECT price FROM `tools` WHERE tool_id='$tool_id'";
        $result_tools = mysqli_query($conn, $select_tools);
        while ($row_tool_price = mysqli_fetch_array($result_tools)) {
          $tool_price = $row_tool_price['price'];
          $total_tool_price += $tool_price; // Add price to total
        }
      }
    }
  
    //Total price calculation
    $total_price = $total_book_price + $total_tool_price;     
    echo $total_price;
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
                echo "<h3 class='text-center mt-5 ' style='overflow:hidden'>You have <span class='text-danger'>$row_count </span> pending orders</h3>";
                echo "<p class='text-center'><a href='profile.php?my_orders' class='text-dark'>Order Details</a></p>";
            } else {
                echo "<h3 class='text-center mt-5 ' style='overflow:hidden'>You have 0 pending orders</h3>";
                echo "<p class='text-center'><a href='../index.php' class='text-dark'>Explore products</a></p>";
            }
        }
    }
}



?>