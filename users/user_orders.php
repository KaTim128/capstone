
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    $username=$_SESSION['user_username']; 
    $get_user="SELECT * FROM `user` WHERE user_username='$username'";
    $result=mysqli_query($conn, $get_user);
    $row_fetch=mysqli_fetch_assoc($result);
    $user_id=$row_fetch['user_id'];
    ?>
    <h4 class="mt-4 text-center text-success" style="overflow:hidden">All my orders</h4>
    <div class="table-container mr-3">
    <table class="table-bordered mt-2  table text-center">
        <thead class="bg-info">
            <tr>
                <th>S1 no</th>
                <th>Amount Due</th>
                <th>Total Products</th>
                <th>Invoice Number</th>
                <th>Date</th>
                <th>Complete/Incomplete</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody class="bg-secondary text-light">
            <?php          
                $get_order_details="SELECT * FROM `orders` WHERE user_id=$user_id";
                $result_orders=mysqli_query($conn, $get_order_details);
                $number = 1;
                while($row_orders=mysqli_fetch_assoc($result_orders)){
                    $order_id=$row_orders['order_id'];
                    $amount_due=$row_orders['amount_due'];
                    $total_products=$row_orders['total_products'];
                    $invoice_number=$row_orders['invoice_number'];
                    $order_date=$row_orders['order_date'];
                    $order_status=$row_orders['order_status'];
                    if($order_status=='pending'){
                        $order_status='Incomplete';
                    }else{
                        $order_status='Complete';
                    }

                    echo "<tr>
                        <td>$number</td>
                        <td>RM$amount_due</td>
                        <td>$total_products</td>
                        <td>$invoice_number</td>
                        <td>$order_date</td>
                        <td>$order_status</td>";
                        ?>
                        <?php
                        if($order_status=='Complete'){
                            echo"<td>Paid</td>";
                        }else{
                       echo "<td><a href='confirm_payment.php?order_id=$order_id' class='text-light'>Confirm</a></td>
                    </tr>";
                        }
                    $number++; 
                }
            ?>
        </tbody>
    </table>
    </div>
</body>
</html>