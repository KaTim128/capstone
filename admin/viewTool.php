<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print N Pixel</title>
    <link rel="icon" type="image/png" href="./images/logo_new.png">
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
        /* Add styles for scrollable table */
        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <?php
        // Display alert message for no tools
        $alertMessage = ''; // Initialize the alert message variable

        $get_tools = "SELECT * FROM `tools`";
        $result = mysqli_query($conn, $get_tools);
        $row_count = mysqli_num_rows($result);

        if ($row_count == 0) {
            $alertMessage = '<div class="p1 alert alert-warning text-center mt-4" style="margin: 0 auto; width: fit-content;">
                                There are no tools yet.
                              </div>';
        }
    ?>
    
    <!-- Display the alert message -->
    <div id="alertContainer">
        <?php echo $alertMessage; ?>
    </div>

    
    <div class="p1 table-responsive mt-2">
        <table class="p1 table table-bordered">
            <?php
            if ($row_count > 0) {
                echo "
                <h4 class='text-center '>All Tools</h4>
                <thead class='table-color'>
                        <tr class='text-center'>
                            <th class='p1'>Tool ID</th>
                            <th class='p1'>Tool Title</th>
                            <th class='p1'>Tool Image</th>
                            <th class='p1'>Tool Price</th>
                            <th class='p1'>Total Sold</th>
                            <th class='p1'>Status</th>
                            <th class='p1'>Edit</th>
                            <th class='p1'>Delete</th>
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
                            $get_count = "SELECT * FROM `orders` WHERE tool_id=$tool_id";
                            $result_count = mysqli_query($conn, $get_count);
                            $rows_count = mysqli_num_rows($result_count);
                            echo $rows_count;
                            ?>
                        </td>
                        <td><?php echo $tool_status; ?></td>
                        <td><a href='adminPanel.php?editTool=<?php echo $tool_id ?>' class='text-light'><i class='fa-solid fa-pen-to-square'></i></a></td>
                        <td><a href="#" class="p1 text-light" data-toggle="modal" data-target="#deleteModal" onclick="setToolId(<?php echo $tool_id; ?>)"><i class='fa-solid fa-trash'></i></a></td>
                    </tr>
                    <?php
                }
                echo "</tbody>";
            }
            ?>
        </table>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="p1 modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="p1 modal-dialog" role="document">
            <div class="p1 modal-content">
                <div class="p1 modal-body">
                    <h6 style="overflow:hidden;">Are you sure you would like to delete this Tool?</h6>
                </div>
                <div class="p1 modal-footer">
                    <button type="button" class="p1 btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="p1 btn btn-danger" id="confirmDelete">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Store tool ID for deletion
        let toolId = null;

        function setToolId(id) {
            toolId = id; // Store the tool ID when delete button is clicked
        }

        // Handle delete confirmation
        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (toolId) {
                // Redirect to PHP delete action with the tool_id
                window.location.href = `adminPanel.php?deleteTool=${toolId}`;
            }
        });

        // Slide-up effect for alert message after 3 seconds
        window.onload = function () {
            const alertContainer = document.getElementById("alertContainer");

            if (alertContainer.innerHTML.trim() !== "") {
                setTimeout(() => {
                    $(alertContainer).slideUp(600, () => {
                        alertContainer.innerHTML = ""; // Clear the alert after the slide-up animation
                    });
                }, 3000);
            }
        };
    </script>
</body>
</html>
