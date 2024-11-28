<?php
include('../database/connection.php');

$alertMessage = ''; // Initialize the alert message variable

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
    $temp_image = $_FILES['image']['tmp_name'];

    // Checking empty conditions
    if ($book_title == '' || $author == '' || $description == '' || $keyword == '' || $book_course == '' || $price == '' || $image == '') {
        $alertMessage = '<div class="p1 alert alert-danger alert-dismissible fade show" role="alert">
                            Please fill in all the available fields!
                            <button type="button" class="p1 close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
    } else {
        // Move image into folder
        move_uploaded_file($temp_image, "./bookImages/$image");

        // Insert query
        $insert_book = "INSERT INTO `books` (book_title, author, description, keyword, course_id, image, price, date, status) 
                        VALUES ('$book_title', '$author','$description', '$keyword', '$book_course', '$image', '$price', NOW(), '$status')";
        $result_query = mysqli_query($conn, $insert_book);

        if ($result_query) {
            // Success alert message
            $alertMessage = '<div class="p1 alert alert-success alert-dismissible fade show" role="alert">
                                Successfully added the book!
                                <button type="button" class="p1 close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
        } else {
            $alertMessage = '<div class="p1 alert alert-danger alert-dismissible fade show" role="alert">
                                Failed to add the book. Please try again later.
                                <button type="button" class="p1 close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
            // Optionally, output the MySQL error for debugging
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

        /* Center the text in alert messages */
        .alert {
            text-align: center;
        }
    </style>

</head>

<body class="p1 bg-light">
    <div id="alertContainer">
        <?php echo $alertMessage; ?>
    </div>

    <div class="p1 container mt-3">
        <h4 class="p1 text-center " style="overflow:hidden;">Insert Books</h4>
        <!-- Form -->
        <form action="" method="post" enctype="multipart/form-data" class="p1 form-container">
            <!-- Book Title -->
            <div class="p1 form-outline w-100">
                <label for="book_title" class="p1 form-label">Book Title</label>
                <input type="text" name="book_title" id="book_title" class="p1 form-control" placeholder="Enter Book Title" autocomplete="off" required>
            </div>

            <div class="p1 form-outline w-100">
                <label for="author" class="p1 form-label">Book Author</label>
                <input type="text" name="author" id="author" class="p1 form-control" placeholder="Enter Book Author" autocomplete="off" required>
            </div>

            <!-- Book Description -->
            <div class="p1 form-outline w-100">
                <label for="description" class="p1 form-label">Book Description</label>
                <textarea name="description" id="description" class="p1 form-control" placeholder="Enter Description" required></textarea>
            </div>

            <!-- Book Keywords -->
            <div class="p1 form-outline w-100">
                <label for="keyword" class="p1 form-label">Book Keywords</label>
                <input type="text" name="keyword" id="keyword" class="p1 form-control" placeholder="Enter Book Keyword" autocomplete="off" required>
            </div>

            <!-- Book Courses -->
            <div class="p1 form-outline w-100">
                <label for="book_course" class="p1 form-label">Select a Course</label>
                <select name="book_course" id="book_course" class="p1 form-control" required>
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
            <div class="p1 form-outline w-100">
                <label for="image" class="p1 form-label">Book Image</label>
                <input type="file" name="image" id="image" class="p1 form-control" required>
            </div>

            <!-- Book Price -->
            <div class="p1 form-outline w-100">
                <label for="price" class="p1 form-label">Book Price</label>
                <input type="number" name="price" id="price" class="p1 form-control" placeholder="Enter Book Price" autocomplete="off" step="0.01" required>
            </div>

            <!-- Submit Button -->
            <div class="p1 form-outline w-100">
                <input type="submit" name="insert_book" class="p1 btn btn-style" value="Insert Book">
            </div>
        </form>
    </div>

    <!-- Bootstrap JS links -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> <!-- Full version of jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>

    <!-- Optional: Slide-up effect on alert message -->
    <script>
        window.onload = function () {
        const alertContainer = document.getElementById("alertContainer");

        // If the alert container has content, make it slide up after 3 seconds
        if (alertContainer.innerHTML.trim() !== "") {
            setTimeout(() => {
                // Slide up the alert
                $(alertContainer).slideUp(600, () => {
                    alertContainer.innerHTML = ""; // Clear the alert after the slide-up animation
                });
            }, 3000);
        }
    };
</script>

</body>

</html>
