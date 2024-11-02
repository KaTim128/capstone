<?php
include('../database/connection.php');
session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if(isset($_GET['order_id'])){
    $order_id=$_GET['order_id'];
    $select_data="SELECT * FROM `orders` WHERE order_id=$order_id";
    $result=mysqli_query($conn,$select_data);
    $row_fetch=mysqli_fetch_assoc($result);
    $invoice_number=$row_fetch['invoice_number'];
    $amount_due=$row_fetch['amount_due'];
} 

if (isset($_POST['confirm_payment'])) {
    $invoice = $_POST['invoice_number'];
    $amount = $_POST['amount'];
    $payment_mode = $_POST['payment_mode'];

    // Insert payment details into user_payments table
    $insert_query = "INSERT INTO `user_payments` (user_id, invoice_number, amount, payment_mode) VALUES ($user_id, '$invoice', $amount, '$payment_mode')";
    $result = mysqli_query($conn, $insert_query);

    if ($result) {
        // Update order status to 'complete'
        $update_orders = "UPDATE `orders` SET order_status='complete' WHERE order_id=$order_id";
        $result_orders = mysqli_query($conn, $update_orders);

        // removing the order from orders table if the update was successful
        if ($result_orders) {
            $delete_order = "DELETE FROM `pending_orders` WHERE order_id=$order_id AND invoice_number=$invoice_number";
            mysqli_query($conn, $delete_order);
        }

        echo "<script>alert('Payment Successful! Thank you for shopping with us!')</script>";
        echo "<script>window.open('profile.php?orders', '_self')</script>"; 
    } 
}  
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style.css">
    <style>
        .form-outline {
            margin-bottom: 20px; 
        }

        .form-select {
            border-radius: 5px; 
            padding: 10px; 
        }


    </style>

</head>
<body class="light-green">
    <div class="container my-5">
        <h1 class="text-center text-dark mb-4" style="overflow:hidden">Confirm Payment</h1>
        <form action="" method="post" class="text-center w-50 m-auto">
    <div class="form-outline my-4">
        <label for="invoice_number" class="text-dark">Invoice Number</label>
        <input type="text" id="invoice_number" class="form-control w-100 text-center" name="invoice_number" value="<?php echo $invoice_number ?>" readonly>
    </div>

    <div class="form-outline my-4">
        <label for="amount" class="text-dark">Amount (RM)</label>
        <input type="text" id="amount" class="form-control w-100 text-center" name="amount" value="<?php echo $amount_due ?>" readonly>
    </div>

    <div class="form-outline my-5">
        <select id="payment_mode" name="payment_mode" class="form-select w-100" style="text-align-last: center; padding-left: 10px; text-indent: 10px;" required>
            <option value="" hidden>Select Payment Mode</option>
            <option value="UPI">UPI</option>
            <option value="Netbanking">Netbanking</option>
            <option value="Paypal">Paypal</option>
            <option value="Cash on Delivery">Cash on Delivery</option>
        </select>
    </div>

    <div class="form-outline text-center" style="margin-top:-12px;">
    <a href="profile.php" class="btn py-2 px-5 border-0 text-light btn-style me-3 mx-2" style="text-decoration: none;">Back</a>
    <input type="submit" class="btn py-2 px-5 border-0 text-light btn-style mx-2" value="Confirm" name="confirm_payment">
    </div>

</form>

    </div>

<!-- bootstrap link-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>