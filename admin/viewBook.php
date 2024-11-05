<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        h4 {
            overflow-y: hidden;
        }

        .book_img {
            width: 100px;
            object-fit: contain;
        }

        td {
            word-wrap: break-word;
            max-width: 150px;
        }

        th, td {
            width: 150px;
        }

        /* Add styles for scrollable table */
        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <h4 class="text-center text-success mt-4">All Books</h4>
    <div class="table-responsive"> <!-- Added this div for scrollable table -->
        <table class="table table-bordered mt-2">
            <?php
            $get_books = "SELECT * FROM `books`";
            $result = mysqli_query($conn, $get_books);
            $row_count = mysqli_num_rows($result); // Get row count

            if ($row_count == 0) {
                echo "<div class='alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>There are no books yet.</div>";
            } else {
                echo "<thead class='table-color'>
                        <tr class='text-center'>
                            <th>Book ID</th>
                            <th>Book Title</th>
                            <th>Book Image</th>
                            <th>Book Price</th>
                            <th>Total Sold</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                      </thead>
                      <tbody class='bg-secondary text-light'>";
                
                $number = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $book_id = $row['book_id'];
                    $book_title = $row['book_title'];
                    $book_image = $row['image'];
                    $book_price = $row['price'];
                    $book_status = $row['status'];
                    $number++;
                    ?>
                    <tr class='text-center'>
                        <td><?php echo $number; ?></td>
                        <td><?php echo $book_title; ?></td>
                        <td><img src='./bookImages/<?php echo $book_image; ?>' class='book_img' /></td>
                        <td>RM<?php echo $book_price; ?></td>
                        <td>
                            <?php
                            $get_count = "SELECT * FROM `orders` WHERE book_id=$book_id";
                            $result_count = mysqli_query($conn, $get_count);
                            $rows_count = mysqli_num_rows($result_count);
                            echo $rows_count;
                            ?>
                        </td>
                        <td><?php echo $book_status; ?></td>
                        <td><a href='adminPanel.php?editBook=<?php echo $book_id ?>' class='text-light'><i class='fa-solid fa-pen-to-square'></i></a></td>
                        <td><a href="#" class="text-light" data-toggle="modal" data-target="#deleteModal" onclick="setBookId(<?php echo $book_id; ?>)"><i class='fa-solid fa-trash'></i></a></td>
                    </tr>
                    <?php
                }
                echo "</tbody>";
            }
            ?>
        </table>
    </div> <!-- End of the scrollable table div -->

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h6>Are you sure you would like to delete this book?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBook">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Store book ID for deletion
        let bookId = null;

        function setBookId(id) {
            bookId = id; // Store the book ID when delete button is clicked
        }

        // Handle delete confirmation
        document.getElementById('confirmDeleteBook').addEventListener('click', function() {
            if (bookId) {
                // Redirect to PHP delete action with the book_id
                window.location.href = `adminPanel.php?deleteBook=${bookId}`;
            }
        });
    </script>
</body>
</html>
