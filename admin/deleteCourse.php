<?php
if(isset($_GET['deleteCourse'])){
    $delete_course=$_GET['deleteCourse'];
    $delete_query="DELETE FROM `courses` WHERE course_id=$delete_course";
    $result=mysqli_query($conn,$delete_query);
    if($result){
        echo "<script>alert('Course has been deleted successfully')</script>";
        echo "<script>window.open('adminPanel.php?viewCourse', '_self');</script>";
    }
}
?>