<?php
include('../database/connection.php');
if (isset($_GET['deletePayments'])) {
    $payment_id = $_GET['deletePayments'];
    if ($conn) {
        $delete_query = "DELETE FROM `user_payments` WHERE `payment_id` = '$payment_id'";
        $result = mysqli_query($conn, $delete_query);
        
        if ($result) {
            echo "<script>window.location.href='adminPanel.php?listPayments';</script>";
        } else {
            echo "<script>alert('Failed to delete payment');</script>";
        }
    } else {
        echo "Connection is null"; 
    }
}

?>