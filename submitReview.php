<?php
include('./database/connection.php');
session_start();

$username = $_SESSION['user_username']; 
    $get_user = "SELECT * FROM `user` WHERE user_username='$username'";
    $result = mysqli_query($conn, $get_user);
    $row_fetch = mysqli_fetch_assoc($result);
    $user_id = $row_fetch['user_id'];
    $username = $row_fetch['user_username'];


if(isset($_POST['rating']) && isset($_POST['review'])) {
    $rating = $_POST['rating'];
    $review = mysqli_real_escape_string($conn, $_POST['review']);

    $sql = "INSERT INTO review (user_id, name, content, rating) VALUES ('$user_id', '$username', '$review', '$rating')";

    if(mysqli_query($conn, $sql)) {
        echo "Review submitted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "All fields are required.";
}
?>



