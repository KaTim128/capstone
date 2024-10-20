<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
</head>
<body>
    <!-- display course title -->
    <?php
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
                echo "<script>alert('Course title updated successfully!');</script>";
                echo "<script>window.open('adminPanel.php?viewCourse', '_self');</script>";
            } else {
                echo "<script>alert('Error updating course title.');</script>";
            }
        }
    ?>
    <div class="container mt-3">
        <h1 class="text-center mb-4" style="overflow:hidden">Edit Course</h1>
        <form action="" method="post" class="text-center">
            <div class="form-outline text-center w-50 m-auto">
                <label for="course_title" class="form-label">Course Title</label>
                <input type="text" name="course_title" id="course_title" class="form-control mb-4" value="<?php echo $course_title; ?>" required="required">
            </div>
            <input type="submit" name="update_course" value="Update Course" class="btn btn-info px-3 mb-3">
        </form>
    </div>
</body>
</html>
