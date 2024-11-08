<?php
if(isset($_GET['editBook'])){
    $edit_id = $_GET['editBook'];
    $get_data = "SELECT * FROM `books` WHERE book_id=$edit_id";
    $result = mysqli_query($conn, $get_data);
    $row = mysqli_fetch_assoc($result);
    $book_title = $row['book_title'];
    $author = $row['author'];
    $description = $row['description'];
    $image = $row['image'];
    $keyword = $row['keyword'];
    $course_id = $row['course_id'];
    $price = $row['price'];

    $select_courses = "SELECT * FROM `courses` WHERE course_id=$course_id";
    $result_courses = mysqli_query($conn, $select_courses);
    $row_course = mysqli_fetch_assoc($result_courses);
    $course_title = $row_course['course_title'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
</head>
<body>
    <div class="container mt-1">
        <h1 class="text-center mb-4" style="overflow:hidden;">Edit Book</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-outline w-50 m-auto mb-4">
                <label for="book_title">Book Title</label>
                <input type="text" id="book_title" value="<?php echo $book_title ?>" name="book_title" class="form-control mb-4" placeholder="Book Title" required="required">
            </div>
            <div class="form-outline w-50 m-auto mb-4">
                <label for="book_author">Book Author</label>
                <input type="text" id="book_author" value="<?php echo $author ?>" name="book_author" class="form-control mb-4" placeholder="Book Author" required="required">
            </div>
            <div class="form-outline w-50 m-auto mb-4">
                <label for="book_desc">Book Description</label>
                <input type="text" id="book_desc" value="<?php echo $description ?>" name="book_desc" class="form-control mb-4" placeholder="Book Description" required="required">
            </div>
            <div class="form-outline w-50 m-auto mb-4">
                <label for="book_keywords">Book Keywords</label>
                <input type="text" id="book_keywords" value="<?php echo $keyword ?>" name="book_keywords" class="form-control mb-4" placeholder="Book Keywords" required="required">
            </div>
            <div class="form-outline w-50 m-auto mb-4">
                <label for="book_course">Course</label>
                <select name="book_course" id="book_course" class="form-control mb-4" required>
                    <option value="<?php echo $course_id; ?>"><?php echo $course_title; ?></option>
                    <?php
                    $select_course_all = "SELECT * FROM `courses`";
                    $result_course_all = mysqli_query($conn, $select_course_all);
                    while ($row_course_all = mysqli_fetch_assoc($result_course_all)) {
                        $course_title = $row_course_all['course_title'];
                        $course_id = $row_course_all['course_id'];
                        echo "<option value='$course_id'>$course_title</option>";
                    };
                    ?>
                </select>
            </div>
            <div class="form-outline w-50 m-auto mb-4">
                <label for="book_image">Book Image</label>
                <div class="d-flex align-items-center mb-4">
                    <input type="file" id="book_image" name="book_image" class="form-control" placeholder="image" style="flex-grow: 1;">
                    <img src="./bookImages/<?php echo $image ?>" alt="Book Image" style="width: 80px; height: auto; margin-left: 10px;">
                </div>   
            </div>
            <div class="form-outline w-50 m-auto mb-4">
                <label for="book_price">Book Price</label>
                <input type="text" id="book_price" value="<?php echo $price ?>" name="book_price" class="form-control mb-4" placeholder="Book Price" required="required">
            </div>
            <div class="w-50 m-auto">
                <input type="submit" name="edit_book" value="Update Book" class="btn btn-style px-3 mb-3">
            </div>
        </form>
    </div>
    <?php
    if (isset($_POST['edit_book'])) {
        $book_title = $_POST['book_title'];
        $book_author = $_POST['book_author'];
        $book_desc = $_POST['book_desc'];
        $book_keywords = $_POST['book_keywords'];
        $book_course = $_POST['book_course'];
        $book_price = $_POST['book_price'];
        $book_image = $_FILES['book_image']['name'];
        $temp_image = $_FILES['book_image']['tmp_name'];
        if (!empty($book_image)) {
            move_uploaded_file($temp_image, "./bookImages/$book_image");
        } else {
            $book_image = $image; 
        }
        $update_book = "UPDATE `books` 
        SET book_title='$book_title', 
            author='$book_author', 
            description='$book_desc', 
            keyword='$book_keywords',                 
            course_id='$book_course', 
            price='$book_price', 
            image='$book_image' 
        WHERE book_id='$edit_id'";

// Execute the query
$result_update = mysqli_query($conn, $update_book);

if ($result_update) {
echo "<script>alert('Book details updated successfully!');</script>";
echo "<script>window.open('adminPanel.php?viewBook', '_self');</script>";
} else {
echo "<script>alert('Error updating book details: " . mysqli_error($conn) . "');</script>";
}

        }
    ?>   
</body>
</html>
