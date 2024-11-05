<?php
include('../database/connection.php');
include('../functions/common_function.php');

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
}

$get_ip_address = getIPAddress();
$total_price = 0;

// Query for cart items based on user ID
$cart_query_price = "SELECT * FROM `cart` WHERE user_id='$user_id'";
$result_cart_price = mysqli_query($conn, $cart_query_price);
$invoice_num = mt_rand();
$status = 'pending';

// Iterate through the cart items
while ($row_price = mysqli_fetch_array($result_cart_price)) {
    $quantity = $row_price['quantity'];
    $book_id = null;
    $tool_id = null;

    // If the item is a book
    if (!empty($row_price['book_id'])) {
        $book_id = $row_price['book_id'];
        $select_books = "SELECT * FROM `books` WHERE book_id='$book_id'";
        $run_price = mysqli_query($conn, $select_books);

        while ($row_book_price = mysqli_fetch_array($run_price)) {
            $book_price = $row_book_price['price'];
            $total_price += $book_price * $quantity;    

            // Insert book into orders
            $insert_orders_pending = "INSERT INTO `orders` 
            (user_id, amount_due, invoice_number, order_date, order_status, book_id, quantity) 
            VALUES ($user_id, $book_price * $quantity, $invoice_num, NOW(), '$status', 'b$book_id', $quantity)";
            $result_pending_query = mysqli_query($conn, $insert_orders_pending);
        }
    }

    // If the item is a tool (stationery)
    if (!empty($row_price['tool_id'])) {
        $tool_id = $row_price['tool_id'];
        $select_tools = "SELECT * FROM `tools` WHERE tool_id='$tool_id'";
        $run_price = mysqli_query($conn, $select_tools);

        while ($row_tool_price = mysqli_fetch_array($run_price)) {
            $tool_price = $row_tool_price['price'];
            $total_price += $tool_price * $quantity;  

            // Insert tool into orders
            $insert_orders_pending = "INSERT INTO `orders` 
            (user_id, amount_due, invoice_number, order_date, order_status, tool_id, quantity) 
            VALUES ($user_id, $tool_price * $quantity, $invoice_num, NOW(), '$status', 't$tool_id', $quantity)";
            $result_pending_query = mysqli_query($conn, $insert_orders_pending);
        }
    }
}

// Clear items from the cart
$empty_cart = "DELETE FROM `cart` WHERE user_id='$user_id'";
$result_delete = mysqli_query($conn, $empty_cart);

// Display success message and 3-second redirect
echo "<div style='text-align: center; margin-top: 40px;'>
        <h2>Orders submitted successfully!</h2>
        <p>You will be redirected to your profile shortly...</p>
      </div>";

echo "<script>
        setTimeout(function() {
            window.location.href = 'profile.php';
        }, 3000);
      </script>";
?>
