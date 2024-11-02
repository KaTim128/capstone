<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Tools</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        h4 {
            overflow-y: hidden;
        }
        .tool_img {
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
    </style>
</head>
<body>
    <h4 class="text-center text-success">All Tools</h4>
    <div class="table-responsive mt-2"> <!-- Add this div for responsiveness -->
        <table class="table table-bordered">
            <?php
            $get_tools = "SELECT * FROM `tools`";
            $result = mysqli_query($conn, $get_tools);
            $row_count = mysqli_num_rows($result); // Set the row count
            
            if ($row_count == 0) {
                echo "<div class='alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>There are no tools yet.</div>";
            } else {
                echo "<thead class='bg-info'>
                        <tr class='text-center'>
                            <th>Tool ID</th>
                            <th>Tool Title</th>
                            <th>Tool Image</th>
                            <th>Tool Price</th>
                            <th>Total Sold</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                      </thead>
                      <tbody class='bg-secondary text-light'>";
                
                $number = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $tool_id = $row['tool_id'];
                    $tool_title = $row['tool_title'];
                    $tool_image = $row['image'];
                    $tool_price = $row['price'];
                    $tool_status = $row['status'];
                    $number++;
                    ?>
                    <tr class='text-center'>
                        <td><?php echo $number; ?></td>
                        <td><?php echo $tool_title; ?></td>
                        <td><img src='./toolImages/<?php echo $tool_image; ?>' class='tool_img' /></td>
                        <td>RM<?php echo $tool_price; ?></td>
                        <td>
                            <?php
                            $get_count = "SELECT * FROM `pending_orders` WHERE tool_id=$tool_id";
                            $result_count = mysqli_query($conn, $get_count);
                            $rows_count = mysqli_num_rows($result_count);
                            echo $rows_count;
                            ?>
                        </td>
                        <td><?php echo $tool_status; ?></td>
                        <td><a href='adminPanel.php?editTool=<?php echo $tool_id ?>' class='text-light'><i class='fa-solid fa-pen-to-square'></i></a></td>
                        <td><a href="#" class="text-light" data-toggle="modal" data-target="#deleteModal" onclick="setToolId(<?php echo $tool_id; ?>)"><i class='fa-solid fa-trash'></i></a></td>
                    </tr>
                    <?php
                }
                echo "</tbody>";
            }
            ?>
        </table>
    </div> <!-- Close the table-responsive div -->

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h6>Are you sure you would like to delete this Tool?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let toolId = null;

        function setToolId(id) {
            toolId = id; // Store the tool ID when delete button is clicked
        }

        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (toolId) {
                window.location.href = `adminPanel.php?deleteTool=${toolId}`; // Redirect to delete
            }
        });
    </script>
</body>
</html>
