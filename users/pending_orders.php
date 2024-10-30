<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Orders</title>
    <style>
        .pending-order {
            background-color: #6c757d; /* Grey background */
            color: #ffffff; /* Light text color */
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
    <h4 class="mt-4 text-center text-success" style="overflow:hidden">Pending Orders</h4>
    <div class="table-container mr-3">
        <table class="table-bordered mt-2 table text-center">
            <tbody class="bg-secondary text-light">
                <?php          
                    // Fetch only pending (incomplete) orders
                    $get_order_details = "SELECT * FROM `orders` WHERE user_id=$user_id AND order_status='pending'";
                    $result_orders = mysqli_query($conn, $get_order_details);

                    if (mysqli_num_rows($result_orders) == 0) {                
                        echo "
                        <div class='alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>No pending orders available</div>";
                    } else {

                        // Display table header only if there are pending orders
                        echo "<thead class='bg-info'>
                                <tr>
                                    <th>S1 no</th>
                                    <th>Amount Due</th>
                                    <th>Total Products</th>
                                    <th>Invoice Number</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
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

                            // In case status is 'pending', mark it as incomplete
                            if ($order_status == 'pending') {
                                $order_status = 'Incomplete';
                            }

                            echo "<tr class='pending-order'>
                                <td>$number</td>
                                <td>RM$amount_due</td>
                                <td>$total_products</td>
                                <td>$invoice_number</td>
                                <td>$order_date</td>
                                <td>$order_status</td>";

                            // If incomplete, show the "Confirm" link, otherwise display "Paid"
                            if ($order_status == 'Incomplete') {
                                echo "<td><a href='confirm_payment.php?order_id=$order_id' class='text-light'>Confirm</a></td>
                                </tr>";
                            } else {
                                echo "<td>Paid</td></tr>";
                            }

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
