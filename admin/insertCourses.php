<?php
include('../database/connection.php');

if(isset($_POST['insert_course'])){
    $course_title = $_POST['course_title'];

    // Select data from database to check if course already exists
    $select_query = "SELECT * FROM `courses` WHERE course_title = '$course_title'";
    $result_select = mysqli_query($conn, $select_query);
    $number = mysqli_num_rows($result_select);

    if($number > 0){
        echo "<script>alert('This course is already present in the database.')</script>";
    } else {
        // Insert course into database
        $insert_query = "INSERT INTO `courses` (course_title) VALUES ('$course_title')";
        $result = mysqli_query($conn, $insert_query);
        
        if($result){
            echo "<script>alert('Course has been inserted successfully!')</script>";
        } else {
            echo "<script>alert('Failed to insert course.')</script>";
            // Optionally, you can also output the MySQL error for debugging
            echo mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Courses</title>
    <!-- Bootstrap CSS link-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h4 class="text-center text-success" style="overflow:hidden;">Insert Courses</h4>
        <!-- Form -->
        <form action="" method="post" class="mb-2">
            <div class="input-group w-50 m-auto mb-2">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-receipt"></i>
                </span>
                <input type="text" class="form-control" name="course_title" placeholder="Insert Courses" aria-label="courses" aria-describedby="basic-addon1" required>
            </div>

            <div class="input-group w-50 m-auto">
                <input type="submit" class="btn btn-style mt-3" name="insert_course" value="Insert Courses">
            </div>
        </form>
    </div>

    <!-- Bootstrap JS links -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
