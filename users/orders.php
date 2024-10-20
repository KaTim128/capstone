<?php
include('../database/connection.php');
include('../functions/common_function.php');

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
}

$get_ip_address = getIPAddress();
$total_price = 0;
$total_products = 0;  // New variable to accumulate total number of both books and tools

// Query for cart items based on IP address
$cart_query_price = "SELECT * FROM `cart` WHERE ip_address='$get_ip_address'";
$result_cart_price = mysqli_query($conn, $cart_query_price);
$invoice_num = mt_rand();
$status = 'pending';

// Iterate through the cart items
while ($row_price = mysqli_fetch_array($result_cart_price)) {
    $quantity = $row_price['quantity'];  // Fetch quantity from the cart
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
            $total_products += $quantity;

            // Insert book into pending_orders
            $insert_orders_pending = "INSERT INTO `pending_orders` 
            (user_id, amount_due, invoice_number, total_products, book_id, order_status) 
            VALUES ($user_id, $total_price, $invoice_num, $total_products, '$book_id', '$status')";
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
            $total_products += $quantity;

            // Insert tool into pending_orders
            $insert_orders_pending = "INSERT INTO `pending_orders` 
            (user_id, amount_due, invoice_number, total_products, tool_id, order_status) 
            VALUES ($user_id, $total_price, $invoice_num, $total_products, '$tool_id', '$status')";
            $result_pending_query = mysqli_query($conn, $insert_orders_pending);
        }
    }
}

// Insert into the `orders` table
$insert_orders = "INSERT INTO `orders` 
(user_id, amount_due, total_products, invoice_number, order_date, order_status) 
VALUES ($user_id, $total_price, $total_products, $invoice_num, NOW(), '$status')";
$result_query = mysqli_query($conn, $insert_orders);

if ($result_query) {
    echo "<script>alert('Orders submitted successfully')</script>";
    echo "<script>window.open('profile.php', '_self')</script>";
}

// Delete items from cart
$empty_cart = "DELETE FROM `cart` WHERE ip_address='$get_ip_address'";
$result_delete = mysqli_query($conn, $empty_cart);

?>
