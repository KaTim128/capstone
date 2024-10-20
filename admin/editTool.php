<?php
if (isset($_GET['editTool'])) {
    $edit_id = $_GET['editTool'];
    $get_data = "SELECT * FROM `tools` WHERE tool_id=$edit_id";
    $result = mysqli_query($conn, $get_data);
    $row = mysqli_fetch_assoc($result);
    $tool_title = $row['tool_title'];
    $description = $row['description'];
    $image = $row['image'];
    $keyword = $row['keyword'];
    $stationery_id = $row['stationery_id'];
    $price = $row['price'];

    // Fetch stationery name
    $select_stationeries = "SELECT * FROM `stationery` WHERE stationery_id=$stationery_id";
    $result_stationeries = mysqli_query($conn, $select_stationeries);
    $row_stationery = mysqli_fetch_assoc($result_stationeries);
    $stationery_title = $row_stationery['stationery_title'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tool</title>
</head>
<body>
    <div class="container mt-1">
        <h1 class="text-center mb-4" style="overflow:hidden;">Edit Tool</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-outline w-50 m-auto mb-4">
                <label for="tool_title">Tool Title</label>
                <input type="text" id="tool_title" value="<?php echo $tool_title ?>" name="tool_title" class="form-control mb-4" placeholder="Tool Title" required="required">
            </div>
            <div class="form-outline w-50 m-auto mb-4">
                <label for="tool_desc">Tool Description</label>
                <input type="text" id="tool_desc" value="<?php echo $description ?>" name="tool_desc" class="form-control mb-4" placeholder="Tool Description" required="required">
            </div>
            <div class="form-outline w-50 m-auto mb-4">
                <label for="tool_keywords">Tool Keywords</label>
                <input type="text" id="tool_keywords" value="<?php echo $keyword ?>" name="tool_keywords" class="form-control mb-4" placeholder="Tool Keywords" required="required">
            </div>
            <div class="form-outline w-50 m-auto mb-4">
                <label for="tools">Stationery</label>
                <select name="tools" id="tools" class="form-control mb-4" required>
                    <option value="<?php echo $stationery_id; ?>"><?php echo $stationery_title; ?></option>
                    <?php
                    $select_stationery_all = "SELECT * FROM `stationery`";
                    $result_stationery_all = mysqli_query($conn, $select_stationery_all);
                    while ($row_stationery_all = mysqli_fetch_assoc($result_stationery_all)) {
                        $stationery_title = $row_stationery_all['stationery_title'];
                        $stationery_id = $row_stationery_all['stationery_id'];
                        echo "<option value='$stationery_id'>$stationery_title</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-outline w-50 m-auto mb-4">
                <label for="tool_image">Tool Image</label>
                <div class="d-flex align-items-center mb-4">
                    <input type="file" id="tool_image" name="tool_image" class="form-control" style="flex-grow: 1;">
                    <img src="./toolImages/<?php echo $image ?>" alt="Tool Image" style="width: 80px; height: auto; margin-left: 10px;">
                </div>
            </div>
            <div class="form-outline w-50 m-auto mb-4">
                <label for="tool_price">Tool Price</label>
                <input type="text" id="tool_price" value="<?php echo $price ?>" name="tool_price" class="form-control mb-4" placeholder="Tool Price" required="required">
            </div>
            <div class="w-50 m-auto">
                <input type="submit" name="edit_tool" value="Update Tool" class="btn btn-info px-3 mb-3">
            </div>
        </form>
    </div>

    <?php
    if (isset($_POST['edit_tool'])) {
        $tool_title = $_POST['tool_title'];
        $tool_desc = $_POST['tool_desc'];
        $tool_keywords = $_POST['tool_keywords'];
        $tools = $_POST['tools'];
        $tool_price = $_POST['tool_price'];
        $tool_image = $_FILES['tool_image']['name'];
        $temp_image = $_FILES['tool_image']['tmp_name'];

        if (!empty($tool_image)) {
            move_uploaded_file($temp_image, "./toolImages/$tool_image");
        } else {
            $tool_image = $image;
        }

        $update_tool = "UPDATE `tools` 
                        SET tool_title='$tool_title', 
                            description='$tool_desc', 
                            keyword='$tool_keywords', 
                            stationery_id='$tools', 
                            price='$tool_price', 
                            image='$tool_image' 
                        WHERE tool_id='$edit_id'";

        if (mysqli_query($conn, $update_tool)) {
            echo "<script>alert('Tool details updated successfully!');</script>"; 
            echo "<script>window.open('adminPanel.php?viewTool', '_self');</script>";     
                  
        } else {
            echo "<script>alert('Error updating tool details: " . mysqli_error($conn) . "');</script>";
        }
    }
    ?>
</body>
</html>
