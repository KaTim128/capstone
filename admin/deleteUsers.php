<?php
include('../database/connection.php');
if (isset($_GET['deleteUsers'])) {
    $user_id = $_GET['deleteUsers'];
    if ($conn) {
        echo "Connected to the database. Proceeding to delete user ID: $user_id"; // Debugging line
        $delete_query = "DELETE FROM `user` WHERE `user_id` = '$user_id'";
        $result = mysqli_query($conn, $delete_query);
        
        if ($result) {
            echo "<script>window.location.href='adminPanel.php?listUsers';</script>";
        } else {
            echo "<script>alert('Failed to delete user');</script>";
        }
    } else {
        echo "Connection is null"; 
    }
}
?>