<?php
include('../database/connection.php');

if (isset($_POST['insert_tool'])) {
    $tool_title = $_POST['tool_title'];
    $description = $_POST['description'];
    $keyword = $_POST['keyword'];
    $tool_stationery = $_POST['tool_stationery'];
    $price = $_POST['price'];
    $status = 'true';

    // Accessing images
    $image = $_FILES['image']['name'];
    // Accessing image temp name
    $temp_image = $_FILES['image']['tmp_name'];

    // Checking empty conditions
    if ($tool_title == '' || $description == '' || $keyword == '' || $tool_stationery == '' || $price == '' || $image == '') {
        echo "<script>alert('Please fill in all the available fields')</script>";
        exit();
    } else {
        // Move image into folder
        move_uploaded_file($temp_image, "./toolImages/$image");

        // Insert query
        $insert_tool = "INSERT INTO `tools` (tool_title, description, keyword, stationery_id, image, price, date, status) 
                        VALUES ('$tool_title', '$description', '$keyword', '$tool_stationery', '$image', '$price', NOW(), '$status')";
        $result_query = mysqli_query($conn, $insert_tool);

        if ($result_query) {
            echo "<script>alert('Successfully added the tool!')</script>";
        } else {
            echo "<script>alert('Failed to add the tool')</script>";
            echo mysqli_error($conn); // Debugging info (optional)
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
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <h4 class="text-center text-success" style="overflow:hidden">Insert Tools</h4>
        <!-- Form -->
        <form action="" method="post" enctype="multipart/form-data" class="form-container">
            <!-- Tool Title -->
            <div class="form-outline w-100">
                <label for="tool_title" class="form-label">Tool Title</label>
                <input type="text" name="tool_title" id="tool_title" class="form-control" placeholder="Enter Tool Title" autocomplete="off" required>
            </div>

            <!-- Tool Description -->
            <div class="form-outline w-100">
                <label for="description" class="form-label">Tool Description</label>
                <textarea name="description" id="description" class="form-control" placeholder="Enter Description" required></textarea>
            </div>

            <!-- Tool Keywords -->
            <div class="form-outline w-100">
                <label for="keyword" class="form-label">Tool Keywords</label>
                <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Enter Tool Keyword" autocomplete="off" required>
            </div>

            <!-- Tool Category -->
            <div class="form-outline w-100">
                <label for="tool_stationery" class="form-label">Select a Stationery</label>
                <select name="tool_stationery" id="tool_stationery" class="form-control" required>
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
            <div class="form-outline w-100">
                <label for="image" class="form-label">Tool Image</label>
                <input type="file" name="image" id="image" class="form-control" required>
            </div>

            <!-- Tool Price -->
            <div class="form-outline w-100">
                <label for="price" class="form-label">Tool Price</label>
                <input type="number" name="price" id="price" class="form-control" placeholder="Enter Tool Price" autocomplete="off"  step="0.01" required>
            </div>

            <!-- Submit Button -->
            <div class="form-outline w-100">
                <input type="submit" name="insert_tool" class="btn btn-style" value="Insert Tool">
            </div>
        </form>
    </div>

    <!-- Bootstrap JS links -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
