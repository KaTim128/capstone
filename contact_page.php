<?php
// Corrected include file name
include('./database/connection.php');
include('./functions/common_function.php');
session_start();

// Initialize variables to avoid undefined variable warnings
$name = '';
$email = '';
$message = '';
$errorMsg = '';
$successMsg = '';

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        $errorMsg = "All fields are required. Try again.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = "Invalid email format.";
    } else {
        // Prepare and execute insert query
        $sql_insert = "INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_insert);

        if ($stmt) {
            // Bind the parameters
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);
            // Execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $successMsg = "Thank you for contacting us! We will get back to you shortly.";
                // Clear inputs after successful submission
                $name = '';
                $email = '';
                $message = '';
            } else {
                $errorMsg = "Error: Could not save your contact information.";
            }
            // Close the prepared statement
            mysqli_stmt_close($stmt);
        } else {
            $errorMsg = "Error: Could not prepare statement.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Print N Pixel</title>
  <link rel="icon" type="image/png" href="./images/logo_new.png">
  <!-- bootstrap CSS link -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <!-- font awesome link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- css file -->
  <link rel="stylesheet" href="style.css">
</head>
<style>
  .contact-form-container {
    margin-top: 65px;
}

</style>
<body>
   <!-- navbar -->
   <div class=" p1 container-fluid p-0 gradient-background">
    <!-- first child  -->
    <nav class=" p1 navbar navbar-expand-lg navbar-dark navbar-color">
      <div class=" p1 container-fluid">
        <img src="./images/logo_new.png" alt="" style="width: 6%; height: 7%; margin-right: 15px; border-radius:5px">
        <button class=" p1 navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=" p1 navbar-toggler-icon"></span>
        </button>

        <div class=" p1 collapse navbar-collapse" id="navbarSupportedContent">
          <ul class=" p1 navbar-nav mr-auto">
            <li class=" p1 nav-item">
              <a class=" p1 nav-link nav-zoom text-light" href="index.php">Products</span></a>
            </li>
            <li class=" p1 nav-item">
              <a class=" p1 nav-link nav-zoom text-light" href="./users/wishlist.php">Wishlist</a>
            </li>
            
            <?php
            if (isset($_SESSION['user_username'])) {
              echo "<li class='nav-item'>
                      <a class='p1 nav-link nav-zoom text-light' href='./users/profile.php'>My Account</a>
                    </li>";
            } else {
              echo "<li class='nav-item'>
                      <a class='p1 nav-link nav-zoom text-light' href='./users/user_login.php'>Login</a>
                    </li>";
            }
            ?> 
            <li class=" p1 nav-item">
              <a class=" p1 nav-link nav-zoom text-light" href="contact_page.php">Contact</a>
            </li>  
            <li class=" p1 nav-item">
              <a class=" p1 nav-link nav-zoom text-light" href="cart.php">Cart<sup><i class="fa fa-shopping-cart" aria-hidden="true"></i><?php cartItem(); ?></sup></a>
            </li>
            <li class=" p1 nav-item">
              <a class=" p1 nav-link text-light" href="#">Total Price: RM<?php totalCartPrice(); ?></a>
            </li>
          </ul>
          <form class=" p1 form-inline my-2 my-lg-0" action="searchProduct.php" method="get">
            <input class=" p1 form-control mr-sm-3" style="width:500px;" type="search" placeholder="Search" aria-label="Search" name="search_data">
            <button class=" p1 btn btn-outline-light my-2 my-sm-0" value="Search" type="submit" name="search_data_product">Search</button>
          </form>
        </div>
      </nav>

<!-- Call cart function -->
<?php 
manageCart(); 
?>

<!-- Second child -->
<ul class=" p1 navbar-nav me-auto">
    <div class=" p1 alert-placeholder"></div> <!-- Placeholder for alert -->
    <div class=" p1 text-center"
         id="alertContainer" 
         data-alert-message="<?php echo htmlspecialchars($errorMsg ?: $successMsg); ?>" 
         data-alert-type="<?php echo $errorMsg ? 'danger' : ($successMsg ? 'success' : ''); ?>" 
         style="position: absolute; width: 100%; display: block;">
    </div>
</ul>


      <!-- fourth child - Contact Form -->
      <div class=" p1 container mb-3 contact-form-container">
        <h3 class=" p1 text-center mb-3 mt-1" style="overflow:hidden">Contact Us</h3>
        
        <form action="contact_page.php" method="POST" class=" p1 contact-form">
            <div class=" p1 form-group">
                <label for="name">Name</label>
                <input type="text" class=" p1 form-control" id="name" name="name" placeholder="Enter your name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class=" p1 form-group">
                <label for="email">Email</label>
                <input type="email" class=" p1 form-control" id="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class=" p1 form-group">
                <label for="message">Message</label>
                <textarea class=" p1 form-control" id="message" name="message" rows="5" placeholder="Enter your message" required><?php echo htmlspecialchars($message); ?></textarea>
            </div>
            <div class=" p1 d-flex mb-2 justify-content-center">
                <button type="submit" class=" p1 btn btn-style">Submit</button>
            </div>
        </form>
    </div>

</div>
      <!-- last child -->
      <?php getFooter(); ?>
    

    <!-- bootstrap link-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="script.js"></script>
  </body>
</html>
