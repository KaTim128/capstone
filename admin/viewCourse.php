<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Courses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        h3 {
            overflow: hidden;
        }

        
    </style>
</head>
<body>
    <h4 class="text-center text-success mt-4" style="overflow:hidden;">All Courses</h4>
    <table class="table table-bordered mt-3">
        <thead class="table-color">
            
        </thead>
        <tbody class="bg-secondary text-light">
            <?php
                $select_courses = "SELECT * FROM `courses`";
                $result = mysqli_query($conn, $select_courses);
                $row_count = mysqli_num_rows($result); // Get row count
                $number = 0;
                if ($row_count == 0) {
                    echo "<div class='alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>There are no courses yet.</div>";
                   } else {
                    echo"<tr class='text-center table-color text-dark'>
                    <th>S.No</th>
                    <th>Course Title</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    </tr>";
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        $course_id = $row['course_id'];
                        $course_title = $row['course_title'];
                        $number++;
                    
            ?>
            <tr class="text-center">
                <td><?php echo $number; ?></td>
                <td><?php echo $course_title; ?></td>
                <td><a href='adminPanel.php?editCourse=<?php echo $course_id ?>' class='text-light'><i class='fa-solid fa-pen-to-square'></i></a></td>
                <td><a href="#" class="text-light" data-toggle="modal" data-target="#deleteModal" onclick="setCourseId(<?php echo $course_id; ?>)"><i class='fa-solid fa-trash'></i></a></td>
            </tr>
            <?php
                    }
                }
            ?>
        </tbody>
    </table>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h6 style="overflow:hidden">Are you sure you would like to delete this Course?</h6>
                </div>
                <div class="modal-footer" >
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Store course ID for deletion
        let courseId = null;

        function setCourseId(id) {
            courseId = id; // Store the course ID when delete button is clicked
        }

        // Handle delete confirmation
        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (courseId) {
                // Redirect to PHP delete action with the course_id
                window.location.href = `adminPanel.php?deleteCourse=${courseId}`;
            }
        });
    </script>
</body>
</html>
