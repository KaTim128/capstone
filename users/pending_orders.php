<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Orders</title>
</head>
<body>
    <?php
    $username = $_SESSION['user_username']; 
    $get_user = "SELECT * FROM `user` WHERE user_username='$username'";
    $result = mysqli_query($conn, $get_user);
    $row_fetch = mysqli_fetch_assoc($result);
    $user_id = $row_fetch['user_id'];
    ?>

    <h4 class="mt-4 text-center text-success" style="overflow:hidden">Pending Orders</h4>
    <div class="table-container mr-3">
        <table class="table-bordered table text-center">
            
                <?php          
                // Fetch only pending (incomplete) orders
                $get_order_details = "SELECT * FROM `orders` WHERE user_id=$user_id AND order_status='pending'";
                $result_orders = mysqli_query($conn, $get_order_details);

                if (mysqli_num_rows($result_orders) == 0) {                
                    echo "<div class='alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>No pending orders available</div>";
                } else {
                    echo "
                    <table class='table-bordered mt-2 table text-center'>
                        <thead class='table-color'>
                            <tr>
                                <th>S1 no</th>
                                <th>Product Name</th>
                                <th>Image</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Amount Due</th>
                                <th>Invoice Number</th>
                                <th>Order Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class='text-dark'>";
                    $number = 1;
                    while ($row_orders = mysqli_fetch_assoc($result_orders)) {
                        $order_id = $row_orders['order_id'];
                        $amount_due = $row_orders['amount_due'];
                        $booktype = $row_orders['booktype'];
                        $invoice_number = $row_orders['invoice_number'];
                        $order_date = $row_orders['order_date'];
                        $order_status = $row_orders['order_status'];
                        $quantity = $row_orders['quantity'];
                        $book_id = $row_orders['book_id'];
                        $tool_id = $row_orders['tool_id'];

                        // Initialize variables for product details
                        $product_name = '';
                        $image_path = '';

                        // Fetch book details if book_id exists
                        if (!empty($book_id)) {
                            $book_id = ltrim($book_id, 'b'); // Remove 'b' prefix
                            $book_query = "SELECT * FROM `books` WHERE book_id='$book_id'";
                            $book_result = mysqli_query($conn, $book_query);
                            if ($book_result && mysqli_num_rows($book_result) > 0) {
                                $book_data = mysqli_fetch_assoc($book_result);
                                $product_name = $book_data['book_title'];
                                $image_path = "../admin/bookImages/" . $book_data['image'];
                            }
                        }

                        // Fetch tool details if tool_id exists
                        if (!empty($tool_id)) {
                            $tool_id = ltrim($tool_id, 't'); // Remove 't' prefix
                            $tool_query = "SELECT * FROM `tools` WHERE tool_id='$tool_id'";
                            $tool_result = mysqli_query($conn, $tool_query);
                            if ($tool_result && mysqli_num_rows($tool_result) > 0) {
                                $tool_data = mysqli_fetch_assoc($tool_result);
                                $product_name = $tool_data['tool_title'];
                                $image_path = "../admin/toolImages/" . $tool_data['image'];
                            }
                        }

                        // Display order details
                        $order_status_display = ($order_status == 'pending') ? 'Incomplete' : 'Complete';
                        echo "<tr class='pending-order'>
                                <td>$number</td>
                                <td>$product_name</td>
                                <td><img src='$image_path' alt='" . htmlspecialchars($product_name) . "' width='50' height='50'></td>
                                <td>$booktype</td>
                                <td>$quantity</td>
                                <td>RM$amount_due</td>
                                <td>$invoice_number</td>
                                <td>$order_date</td>
                                <td>$order_status_display</td>";

                        if ($order_status_display == 'Incomplete') {
                            echo "<td><a href='confirm_payment.php?order_id=$order_id' class='ml-3 btn btn-style text-white'>Confirm</a></td>";
                        } else {
                            echo "<td>Paid</td>";
                        }
                        echo "</tr>";

                        $number++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
