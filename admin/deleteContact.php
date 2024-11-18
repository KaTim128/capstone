<?php
include('../database/connection.php');

if (isset($_GET['deleteContact'])) {
    $contact_id = intval($_GET['deleteContact']); // Use intval to prevent SQL injection

    // SQL to delete the contact message
    $delete_query = "DELETE FROM `contacts` WHERE contact_id=$contact_id";
    $result_msg = mysqli_query($conn, $delete_query);

    if ($result_msg) {
        // Optional: Display a JavaScript alert, if needed
        echo "<script>alert('Message deleted successfully!');</script>";

        // Redirect to adminPanel.php?listMessages
        echo "<script>window.location.href = './adminPanel.php?listMessages';</script>";
    } else {
        // Handle deletion failure (optional)
        echo "<script>alert('Failed to delete message');</script>";
    }
}
?>

