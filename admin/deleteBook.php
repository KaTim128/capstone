<?php
if(isset($_GET['deleteBook'])){
    $delete_id=$_GET['deleteBook'];
    
    $delete_book="DELETE FROM `books` WHERE book_id=$delete_id";
    $result_book=mysqli_query($conn,$delete_book);
    if($result_book){
        echo"<script>alert('Product deleted successfully')</script>";  
        echo"<script>window.open('./adminPanel.php?viewBook','_self')</script>";
    }   
}
?>