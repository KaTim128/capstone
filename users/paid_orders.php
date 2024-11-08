<?php
    $username = $_SESSION['user_username']; 
    $get_user = "SELECT * FROM `user` WHERE user_username='$username'";
    $result = mysqli_query($conn, $get_user);
    $row_fetch = mysqli_fetch_assoc($result);
    $user_id = $row_fetch['user_id'];
?>
    <h4 class="mt-4 text-center text-success" style="overflow:hidden">All Paid Orders</h4>
    <div class="table-container mr-3">
        <table class="table-bordered mt-3 table text-center">
            <?php
            // Fetch only completed and paid orders
            $get_order_details = "SELECT * FROM `orders` WHERE user_id=$user_id AND (order_status = 'complete' OR order_status = 'paid')";
            $result_orders = mysqli_query($conn, $get_order_details);

            if (mysqli_num_rows($result_orders) == 0) {                
                echo "<div class='alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>No paid orders available</div>";
            } else {
                // If there are orders, show the thead
                echo "<thead class='table-color'>
                        <tr>
                            <th>S1 no</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Amount Paid</th>
                            <th>Invoice Number</th>
                            <th>Payment Mode</th>
                            <th>Payment Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody class='text-dark'>";

                $number = 1;
                while ($row_orders = mysqli_fetch_assoc($result_orders)) {
                    $order_id = $row_orders['order_id'];
                    $amount_paid = $row_orders['amount_due'];
                    $booktype = $row_orders['booktype'];
                    $invoice_number = $row_orders['invoice_number'];
                    $order_date = $row_orders['order_date'];
                    $payment_mode = $row_orders['payment_mode'];
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
                    echo "<tr class='paid-order'>
                            <td>$number</td>
                            <td>$product_name</td>
                            <td><img src='$image_path' alt='" . htmlspecialchars($product_name) . "' width='50' height='50'></td>
                            <td>$booktype</td>
                            <td>$quantity</td> 
                            <td>RM$amount_paid</td>
                            <td>$invoice_number</td>
                            <td>$payment_mode</td>
                            <td>$order_date</td>
                            <td>Complete</td>
                            <td>Paid</td>
                          </tr>";

                    $number++;
                }
                echo "</tbody>"; // Closing tbody
            }
            ?>
        </table>
    </div>
</body>
</html>
