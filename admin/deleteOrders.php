<?php
include('../database/connection.php');
if (isset($_GET['deleteOrders'])) {
    $order_id = $_GET['deleteOrders'];
    if ($conn) {
        echo "Connected to the database. Proceeding to delete order ID: $order_id"; // Debugging line
        $delete_query = "DELETE FROM `orders` WHERE `order_id` = '$order_id'";
        $result = mysqli_query($conn, $delete_query);
        
        if ($result) {
            echo "<script>alert('Order deleted successfully');</script>";
            echo "<script>window.location.href='adminPanel.php?listOrders';</script>";
        } else {
            echo "<script>alert('Failed to delete order');</script>";
        }
    } else {
        echo "Connection is null"; 
    }
}

?>