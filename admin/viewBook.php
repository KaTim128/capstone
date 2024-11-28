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
    <div class="p1 table-responsive"> <!-- Added this div for scrollable table -->
        <table class="p1 table table-bordered mt-2">
            <?php
            $get_books = "SELECT * FROM `books`";
            $result = mysqli_query($conn, $get_books);
            $row_count = mysqli_num_rows($result); // Get row count

            if ($row_count == 0) {
                echo "<div class='alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>There are no books yet.</div>";
            } else {
                echo "
                <h4 class='text-center  mt-4'>All Books</h4>
                <thead class='table-color'>
                        <tr class='text-center'>
                            <th class='p1'>Book ID</th>
                            <th class='p1'>Book Title</th>
                            <th class='p1'>Book Image</th>
                            <th class='p1'>Book Price</th>
                            <th class='p1'>Total Sold</th>
                            <th class='p1'>Status</th>
                            <th class='p1'>Edit</th>
                            <th class='p1'>Delete</th>
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
                        <td><a href="#" class="p1 text-light" data-toggle="modal" data-target="#deleteModal" onclick="setBookId(<?php echo $book_id; ?>)"><i class='fa-solid fa-trash'></i></a></td>
                    </tr>
                    <?php
                }
                echo "</tbody>";
            }
            ?>
        </table>
    </div> <!-- End of the scrollable table div -->

    <!-- Delete Confirmation Modal -->
    <div class="p1 modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="p1 modal-dialog" role="document">
            <div class="p1 modal-content">
                <div class="p1 modal-body">
                    <h6 style="overflow:hidden;">Are you sure you would like to delete this book?</h6>
                </div>
                <div class="p1 modal-footer">
                    <button type="button" class="p1 btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="p1 btn btn-danger" id="confirmDeleteBook">Yes, Delete</button>
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
