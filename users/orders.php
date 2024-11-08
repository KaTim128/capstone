<?php
include('../database/connection.php');
include('../functions/common_function.php');

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
}

$get_ip_address = getIPAddress();
$total_price = 0;
$invoice_num = mt_rand();
$status = 'pending';

// Get all cart items for the user
$cart_query_price = "SELECT * FROM `cart` WHERE user_id='$user_id'";
$result_cart_price = mysqli_query($conn, $cart_query_price);

// Prepare the insert query for both books and tools in one go
while ($row_price = mysqli_fetch_array($result_cart_price)) {
    $quantity = $row_price['quantity'];
    $book_id = $row_price['book_id'];
    $tool_id = $row_price['tool_id'];
    $booktype = $row_price['booktype']; // Digital or printed

    // If the item is a book
    if (!empty($book_id)) {
        $select_books = "SELECT * FROM `books` WHERE book_id='$book_id'";
        $run_price = mysqli_query($conn, $select_books);
        $row_book_price = mysqli_fetch_array($run_price);

        if ($row_book_price) {
            $book_price = $row_book_price['price'];

            // If the book is digital, apply a discount to make it 4 times less
            if ($booktype == 'digital') {
                $book_price *= 0.25;  // 4 times less than printed
            }

            // Calculate total price for the current item without rounding up
            $item_total_price = number_format($book_price * $quantity, 2, '.', '');

            // Accumulate to the total order price
            $total_price += $item_total_price;

            // Insert book into orders
            $insert_orders_pending = "INSERT INTO `orders` 
            (user_id, amount_due, invoice_number, order_date, order_status, book_id, quantity, booktype) 
            VALUES ('$user_id', '$item_total_price', '$invoice_num', NOW(), '$status', '$book_id', '$quantity', '$booktype')";
            mysqli_query($conn, $insert_orders_pending);
        }
    }

    // If the item is a tool (stationery)
    if (!empty($tool_id)) {
        $select_tools = "SELECT * FROM `tools` WHERE tool_id='$tool_id'";
        $run_price = mysqli_query($conn, $select_tools);
        $row_tool_price = mysqli_fetch_array($run_price);

        if ($row_tool_price) {
            $tool_price = $row_tool_price['price'];
            
            // Calculate total price for the current item without rounding up
            $item_total_price = number_format($tool_price * $quantity, 2, '.', '');

            // Accumulate to the total order price
            $total_price += $item_total_price;

            // Insert tool into orders
            $insert_orders_pending = "INSERT INTO `orders` 
            (user_id, amount_due, invoice_number, order_date, order_status, tool_id, quantity, booktype) 
            VALUES ('$user_id', '$item_total_price', '$invoice_num', NOW(), '$status', '$tool_id', '$quantity', '-')";
            mysqli_query($conn, $insert_orders_pending);
        }
    }
}

// Clear items from the cart after order is placed
$empty_cart = "DELETE FROM `cart` WHERE user_id='$user_id'";
mysqli_query($conn, $empty_cart);

// Redirect to success_order.php with invoice number
header("Location: success_order.php?invoice_number=$invoice_num");
exit();
?>
