<?php
include('../database/connection.php');

$alertMessage = ''; // Initialize alert message

// Check if course ID is set for editing
if (isset($_GET['editCourse'])) {
    $edit_course = $_GET['editCourse'];

    // Fetch the current course details
    $get_courses = "SELECT * FROM `courses` WHERE course_id = $edit_course";
    $result = mysqli_query($conn, $get_courses);
    $row = mysqli_fetch_assoc($result);
    $course_title = $row['course_title'];
}

// Handle the form submission
if (isset($_POST['update_course'])) {
    $new_course_title = mysqli_real_escape_string($conn, $_POST['course_title']);
    $update_query = "UPDATE `courses` SET course_title = '$new_course_title' WHERE course_id = $edit_course";

    if (mysqli_query($conn, $update_query)) {
        $alertMessage = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Course title updated successfully!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
    } else {
        $alertMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Error updating course title.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <!-- Bootstrap CSS link-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
    <!-- Custom JS to slide up the alert -->
    <script>
        $(document).ready(function() {
            // Slide up alert after 3 seconds
            setTimeout(function() {
                $(".alert").slideUp(500);
            }, 3000); // 3000ms = 3 seconds
        });
    </script>
</head>
<style>
    .alert {
            text-align: center;
        }
</style>
<body class="bg-light">
    <div class="container mt-4">
        <!-- Display alert message if any -->
        <div id="alertContainer">
            <?php echo $alertMessage; ?>
        </div>

        <h1 class="text-center mb-4" style="overflow:hidden;">Edit Course</h1>
        <form action="" method="post" class="text-center">
            <div class="form-outline text-center w-50 m-auto">
                <label for="course_title" class="form-label">Course Title</label>
                <input type="text" name="course_title" id="course_title" class="form-control mb-4" value="<?php echo $course_title; ?>" required="required">
            </div>
            <input type="submit" name="update_course" value="Update Course" class="btn btn-style px-3 mb-3">
        </form>
    </div>
</body>
</html>
