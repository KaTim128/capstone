<?php
if (isset($_GET['deleteBook'])) {
    $delete_id = $_GET['deleteBook'];

    // SQL query to delete the book
    $delete_book = "DELETE FROM `books` WHERE book_id=$delete_id";
    $result_book = mysqli_query($conn, $delete_book);
}
?>
