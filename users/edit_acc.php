<?php
if(isset($_GET['edit_account'])){
    $user_session_name=$_SESSION['user_username']; //session get the username
    //if username matches the session's username
    $select_query="SELECT * FROM `user` WHERE user_username='$user_session_name'";
    $result_query=mysqli_query($conn,$select_query);
    $row_fetch=mysqli_fetch_assoc($result_query);
    $user_id=$row_fetch['user_id'];
    $user_username=$row_fetch['user_username'];
    $user_email=$row_fetch['user_email'];
    $user_image=$row_fetch['user_image'];
    $user_address=$row_fetch['user_address'];
    $user_contact=$row_fetch['user_contact'];
    
}
    if(isset($_POST['user_update'])){
        $update_id=$user_id;
        $user_username=$_POST['user_username'];
        $user_email=$_POST['user_email'];
        $user_address=$_POST['user_address'];
        $user_contact=$_POST['user_contact'];
        if(!empty($_FILES['user_image']['name'])){
            $user_image = $_FILES['user_image']['name'];
            $user_image_tmp = $_FILES['user_image']['tmp_name'];
            move_uploaded_file($user_image_tmp,"./user_images/$user_image");
        } else {
            $user_image = $row_fetch['user_image'];
        }
    
        //update query
        $update_data="UPDATE `user` SET user_username='$user_username',user_email='$user_email',
        user_image='$user_image',user_address='$user_address',user_contact='$user_contact' WHERE 
        user_id=$update_id";
        $result_query_update=mysqli_query($conn,$update_data);
        if($result_query_update){
            echo"<script>alert('Data updated successfully!')</script>";
            echo"<script>window.open('logout.php','_self')</script>";
        }
     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>

</head>
<body>
    <h4 class="mt-4 mb-4 text-center text-success" style="overflow:hidden">Edit Account active</h4>
    <form action="" method="post" enctype="multipart/form-data" class="text-center">
        <div class="form-outline mb-4">
            <input type="text" class="form-control w-50 m-auto" value="<?php echo"$user_username" ?>" name="user_username" placeholder="Username" required>
        </div>
        <div class="form-outline mb-3">
            <input type="email" class="form-control w-50 m-auto" value="<?php echo"$user_email" ?>" name="user_email" placeholder="Email" required>
        </div>
        <div class="form-outline d-flex w-50 m-auto">
            <input type="file" class="form-control m-auto image-bar" name="user_image">
            <img src="./user_images/<?php echo $user_image?>" alt="" class="edit-img">
        </div>
        <div class="form-outline mb-4 mt-3">
            <input type="text" class="form-control w-50 m-auto" value="<?php echo"$user_address" ?>" name="user_address" placeholder="Address" required>
        </div>
        <div class="form-outline mb-3">
            <input type="text" class="form-control w-50 m-auto" value="<?php echo"$user_contact" ?>" name="user_contact" placeholder="Contact" required>
        </div>
        <input type="submit"value="Update" class="bg-info py-2 px-3 border-0"  name="user_update">
    </form>
    
</body>
</html>