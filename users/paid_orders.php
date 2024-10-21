<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paid Orders</title>
    <style>
        .paid-order {
            background-color: #6c757d;
            color: #ffffff; 
        }
    </style>
</head>
<body>
<?php
    $username = $_SESSION['user_username']; 
    $get_user = "SELECT * FROM `user` WHERE user_username='$username'";
    $result = mysqli_query($conn, $get_user);
    $row_fetch = mysqli_fetch_assoc($result);
    $user_id = $row_fetch['user_id'];
?>
    <h4 class="mt-4 text-center text-success" style="overflow:hidden">All Paid Orders</h4>
    <div class="table-container mr-3">
        <table class="table-bordered mt-2 table text-center">
            <tbody class="bg-secondary text-light">
                <?php          
                    // Fetch only paid (completed) orders
                    $get_order_details = "SELECT * FROM `orders` WHERE user_id=$user_id AND order_status != 'pending'";
                    $result_orders = mysqli_query($conn, $get_order_details);

                    if (mysqli_num_rows($result_orders) == 0) {
                        // If no paid orders, show the alert message
                        echo "<div class='alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>No paid orders available</div>";
                    } else {
                        // Display table header only if there are paid orders
                        echo "<thead class='bg-info'>
                                <tr>
                                    <th>S1 no</th>
                                    <th>Amount Due</th>
                                    <th>Total Products</th>
                                    <th>Invoice Number</th>
                                    <th>Date</th>
                                    <th>Order Status</th>
                                    <th>Status</th>
                                </tr>
                              </thead>
                              <tbody>";

                        $number = 1;
                        while ($row_orders = mysqli_fetch_assoc($result_orders)) {
                            $order_id = $row_orders['order_id'];
                            $amount_due = $row_orders['amount_due'];
                            $total_products = $row_orders['total_products'];
                            $invoice_number = $row_orders['invoice_number'];
                            $order_date = $row_orders['order_date'];
                            $order_status = $row_orders['order_status'];

                            // If order is not pending, it is marked as complete
                            if ($order_status != 'pending') {
                                $order_status = 'Complete';
                            }

                            echo "<tr class='paid-order'>
                                <td>$number</td>
                                <td>RM$amount_due</td>
                                <td>$total_products</td>
                                <td>$invoice_number</td>
                                <td>$order_date</td>
                                <td>$order_status</td>
                                <td>Paid</td>
                            </tr>";

                            $number++; 
                        }

                        echo "</tbody>"; // Close tbody tag
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
