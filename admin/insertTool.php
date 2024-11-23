<?php
include('../database/connection.php');

$alertMessage = ''; // Initialize alert message

if (isset($_POST['insert_tool'])) {
    $tool_title = $_POST['tool_title'];
    $description = $_POST['description'];
    $keyword = $_POST['keyword'];
    $tool_stationery = $_POST['tool_stationery'];
    $price = $_POST['price'];
    $status = 'true';

    // Accessing image
    $image = $_FILES['image']['name'];
    $temp_image = $_FILES['image']['tmp_name'];

    // Checking empty conditions
    if ($tool_title == '' || $description == '' || $keyword == '' || $tool_stationery == '' || $price == '' || $image == '') {
        $alertMessage = '<div class="p1 alert alert-danger alert-dismissible fade show" role="alert">
                            Please fill in all the available fields!
                            <button type="button" class="p1 close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
    } else {
        // Move image into folder
        move_uploaded_file($temp_image, "./toolImages/$image");

        // Insert query
        $insert_tool = "INSERT INTO `tools` (tool_title, description, keyword, stationery_id, image, price, date, status) 
                        VALUES ('$tool_title', '$description', '$keyword', '$tool_stationery', '$image', '$price', NOW(), '$status')";
        $result_query = mysqli_query($conn, $insert_tool);

        if ($result_query) {
            $alertMessage = '<div class="p1 alert alert-success alert-dismissible fade show" role="alert">
                                Successfully added the tool!
                                <button type="button" class="p1 close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
        } else {
            $alertMessage = '<div class="p1 alert alert-danger alert-dismissible fade show" role="alert">
                                Failed to add the tool. Please try again later.
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
    <title>Insert Tools into Categories</title>
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

        .alert {
            text-align: center;
        }
        
    </style>
</head>
<body class="p1 bg-light" >
    <div id="alertContainer">
        <?php echo $alertMessage; ?>
    </div>

    <div class="p1 container">
        <h4 class="p1 text-center text-success" style="overflow:hidden;">Insert Tools</h4>
        <!-- Form -->
        <form action="" method="post" enctype="multipart/form-data" class="p1 form-container">
            <!-- Tool Title -->
            <div class="p1 form-outline w-100">
                <label for="tool_title" class="p1 form-label">Tool Title</label>
                <input type="text" name="tool_title" id="tool_title" class="p1 form-control" placeholder="Enter Tool Title" autocomplete="off" required>
            </div>

            <!-- Tool Description -->
            <div class="p1 form-outline w-100">
                <label for="description" class="p1 form-label">Tool Description</label>
                <textarea name="description" id="description" class="p1 form-control" placeholder="Enter Description" required></textarea>
            </div>

            <!-- Tool Keywords -->
            <div class="p1 form-outline w-100">
                <label for="keyword" class="p1 form-label">Tool Keywords</label>
                <input type="text" name="keyword" id="keyword" class="p1 form-control" placeholder="Enter Tool Keyword" autocomplete="off" required>
            </div>

            <!-- Tool Category -->
            <div class="p1 form-outline w-100">
                <label for="tool_stationery" class="p1 form-label">Select a Stationery</label>
                <select name="tool_stationery" id="tool_stationery" class="p1 form-control" required>
                    <option value="">Select a stationery</option>
                    <?php
                    $select_stationaries = "SELECT * FROM `stationery`";
                    $result_stationaries = mysqli_query($conn, $select_stationaries);
                    while ($row = mysqli_fetch_assoc($result_stationaries)) {
                        $stationery_title = $row['stationery_title'];
                        $tool_stationery_id = $row['stationery_id'];
                        echo "<option value='$tool_stationery_id'>$stationery_title</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Tool Image -->
            <div class="p1 form-outline w-100">
                <label for="image" class="p1 form-label">Tool Image</label>
                <input type="file" name="image" id="image" class="p1 form-control" required>
            </div>

            <!-- Tool Price -->
            <div class="p1 form-outline w-100">
                <label for="price" class="p1 form-label">Tool Price</label>
                <input type="number" name="price" id="price" class="p1 form-control" placeholder="Enter Tool Price" autocomplete="off" step="0.01" required>
            </div>

            <!-- Submit Button -->
            <div class="p1 form-outline w-100">
                <input type="submit" name="insert_tool" class="p1 btn btn-style" value="Insert Tool">
            </div>
        </form>
    </div>

    <!-- Bootstrap JS links -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script> <!-- Full version of jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>

    <!-- Custom JS for slide-up effect -->
    <script>
    $(document).ready(function () {
        const alertContainer = $("#alertContainer");

        if (alertContainer.html().trim() !== "") {
            setTimeout(() => {
                // Slide up the alert and remove it from the DOM after animation
                alertContainer.slideUp(600, function () {
                    alertContainer.remove();
                });
            }, 3000); // 3 seconds delay
        }
    });
    </script>
</body>
</html>
