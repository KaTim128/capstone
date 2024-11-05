<?php
include('../database/connection.php');

if (isset($_POST['insert_book'])) {
    $book_title = $_POST['book_title'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $keyword = $_POST['keyword'];
    $book_course = $_POST['book_course'];
    $price = $_POST['price'];
    $status = 'true';

    // Accessing images
    $image = $_FILES['image']['name'];
    // Accessing image temp name
    $temp_image = $_FILES['image']['tmp_name'];

    // Checking empty conditions
    if ($book_title == '' || $author == '' || $description == '' || $keyword == '' || $book_course == '' || $price == '' || $image == '') {
        echo "<script>alert('Please fill in all the available fields')</script>";
        exit();
    } else {
        // Move image into folder
        move_uploaded_file($temp_image, "./bookImages/$image");

        // Insert query
        $insert_book = "INSERT INTO `books` (book_title, author, description, keyword, course_id, image, price, date, status) 
                        VALUES ('$book_title', '$author','$description', '$keyword', '$book_course', '$image', '$price', NOW(), '$status')";
        $result_query = mysqli_query($conn, $insert_book);

        if ($result_query) {
            echo "<script>alert('Successfully added the book!')</script>";
        } else {
            echo "<script>alert('Failed to add the book')</script>";
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
    <title>Insert Books into Courses</title>
    <!-- Bootstrap CSS link-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- CSS file -->
    <link rel="stylesheet" href="../style.css">

    <style>
        body {
            overflow: hidden;
        }
        .form-container {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .form-outline {
            margin-bottom: 1.5rem;
        }
        .btn-info {
            background-color: #17a2b8;
            border: none;
        }
    </style>

</head>

<body class="bg-light">
    <div class="container mt-3">
        <h4 class="text-center text-success" style="overflow:hidden;">Insert Books</h4>
        <!-- Form -->
        <form action="" method="post" enctype="multipart/form-data" class="form-container">
            <!-- Book Title -->
            <div class="form-outline w-100">
                <label for="book_title" class="form-label">Book Title</label>
                <input type="text" name="book_title" id="book_title" class="form-control" placeholder="Enter Book Title" autocomplete="off" required>
            </div>

            <div class="form-outline w-100">
                <label for="author" class="form-label">Book Author</label>
                <input type="text" name="author" id="author" class="form-control" placeholder="Enter Book Author" autocomplete="off" required>
            </div>

            <!-- Book Description -->
            <div class="form-outline w-100">
                <label for="description" class="form-label">Book Description</label>
                <textarea name="description" id="description" class="form-control" placeholder="Enter Description" required></textarea>
            </div>

            <!-- Book Keywords -->
            <div class="form-outline w-100">
                <label for="keyword" class="form-label">Book Keywords</label>
                <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Enter Book Keyword" autocomplete="off" required>
            </div>

            <!-- Book Courses -->
            <div class="form-outline w-100">
                <label for="book_course" class="form-label">Select a Course</label>
                <select name="book_course" id="book_course" class="form-control" required>
                    <option value="">Select a Course</option>
                    <?php
                    $select_courses = "SELECT * FROM `courses`";
                    $result_courses = mysqli_query($conn, $select_courses);
                    while ($row = mysqli_fetch_assoc($result_courses)) {
                        $course_title = $row['course_title'];
                        $course_id = $row['course_id'];
                        echo "<option value='$course_id'>$course_title</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Book Image -->
            <div class="form-outline w-100">
                <label for="image" class="form-label">Book Image</label>
                <input type="file" name="image" id="image" class="form-control" required>
            </div>

            <!-- Book Price -->
            <div class="form-outline w-100">
                <label for="price" class="form-label" >Book Price</label>
                <input type="number" name="price" id="price" class="form-control" placeholder="Enter Book Price" autocomplete="off" required>
            </div>

            <!-- Submit Button -->
            <div class="form-outline w-100">
                <input type="submit" name="insert_book" class="btn btn-style" value="Insert Book">
            </div>
        </form>
    </div>

    <!-- Bootstrap JS links -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
