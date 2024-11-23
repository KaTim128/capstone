<?php
if(isset($_GET['deleteTool'])){
    $delete_id=$_GET['deleteTool'];
    
    $delete_tool="DELETE FROM `tools` WHERE tool_id=$delete_id";
    $result_tool=mysqli_query($conn,$delete_tool);
    if($result_tool){  
        echo"<script>window.open('./adminPanel.php?viewTool','_self')</script>";
    }   
}
?>