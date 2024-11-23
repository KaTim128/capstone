<?php
if(isset($_GET['deleteStationery'])){
    $delete_Stationery=$_GET['deleteStationery'];
    $delete_query="DELETE FROM `stationery` WHERE Stationery_id=$delete_Stationery";
    $result=mysqli_query($conn,$delete_query);
    if($result){
        echo "<script>window.open('adminPanel.php?viewStationery', '_self');</script>";
    }
}
?>