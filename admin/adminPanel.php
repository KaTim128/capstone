<?php
include('../database/connection.php');
include('../functions/common_function.php');
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print N Pixel</title>
    <link rel="icon" type="image/png" href="../images/logo_new.png">
    <!-- bootstrap css link-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--  css file -->
    <link rel="stylesheet" href="../style.css">

    <style>
        .admin-image{
            object-fit:contain;
            width:50%; 
            height:50%; 
            margin-right:5px; 
            border-radius:5px;
            justify-content:center;
            align-items:center;
            display: flex;
            margin: 0 auto;
        }

        .panel {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* Default: 4 columns */
    gap: 10px; /* Space between buttons */
    width: 100%;
    box-sizing: border-box;
    padding: 5px 15px;
    margin-bottom: 5px;
}

/* For tablets and smaller devices */
@media (max-width: 768px) {
    .panel {
        grid-template-columns: repeat(2, 1fr); /* 2 columns for tablets and small screens */
        
    }
}

/* For very small devices like phones */
@media (max-width: 576px) {
    .panel {
        grid-template-columns: repeat(2, 1fr); /* Still 2 columns */
        gap: 5px; /* Reduce gap */
    }
    .btn-responsive {
        font-size: 14px; /* Maintain readability */
        padding: 5px; /* Adjust padding for smaller buttons */
    }
}


        .panel button {
            padding: 6px 10px; /* Adjust padding */
            margin-right: 5px; /* Add right margin for spacing */
            background: linear-gradient(to right, #013220, #013220, #013220);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            color: rgb(255, 255, 255);
            outline: 2px solid #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.3s; /* Smooth transitions */
            font-family: "Open Sans", sans-serif;
            }

        /* Hover effect for all buttons */
        .panel button:hover {
            background: linear-gradient(to right, #013b26, #01452c);
        transform: scale(0.95);
        color: #000000;
        }

        .panel a {
            color: white;
            text-decoration: none;
            display: block;
            width: 100%;
            height: 100%;
            text-align: center;
        }

        

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh; /* Ensure body takes full viewport height */
}

.container-fluid {
    flex: 1; /* This will make sure the container grows to fit the content and pushes the footer down */
}

.container.my-3 {
    margin-bottom: 50px; /* Add some bottom margin to ensure spacing before the footer */
}

.admin-image {
    width: 100px; /* Adjust width as needed */
    height: auto; /* Keeps the aspect ratio */
}

/* Red Logout Button */
.btn-danger {
    background-color: #8B0000 !important; /* Solid red */
    background-image: none !important; /* Removes gradient */
    border: none;
    color: white; /* Ensure white text */
}

.btn-danger:hover {
    background-color: #a71d2a !important; /* Darker red on hover */
    transform: scale(1.05); /* Slight zoom effect */
}

.p1 {
    font-family: "Open Sans", sans-serif;
}
    </style>
</head>
<body>
    
        <!-- first child -->
        <nav class="p1 navbar navbar-expand-lg navbar-light">
            <div class="p1 container-fluid">
                
                <nav class="p1 navbar navbar-expand-lg">
                    <ul class="p1 navbar-nav">
                        <li class="p1 nav-item">
                            <?php
                        if (isset($_SESSION['user_username'])) {
                            echo "<li class='nav-item'>
                                    <a class='nav-link'>Welcome " . htmlspecialchars($_SESSION['user_username']) . "</a>
                                </li>";
                        } ?>
                        </li>
                    </ul>
                </nav>
            </div>
        </nav>

        <!-- second child -->
        <div class="p1 bg-light">
            <h3 class="p1 text-center p-2 mt-2">Manage Details</h3>
        </div>

        <!-- third child -->
<div class="p1 row">
    <div class="p1 col-12 my-3 light-green d-flex flex-column align-items-center">
        <!-- Logo Section -->
        <div class="p1 my-2">
            <a href="#"><img src="../images/logo_new.png" alt="" class="p1 admin-image img-fluid"></a>
        </div>
        <!-- Buttons Panel Section -->
        <div class="p1 panel text-center w-100">
            <button class="p1 btn btn-light btn-responsive mb-2"><a href="adminPanel.php?insertBook" class="p1 nav-link text-light" style="font-weight: bold;">Insert Book</a></button>
            <button class="p1 btn btn-light btn-responsive mb-2"><a href="adminPanel.php?viewBook" class="p1 nav-link text-light" style="font-weight: bold;">View Books</a></button>
            <button class="p1 btn btn-light btn-responsive mb-2"><a href="adminPanel.php?insertCourse" class="p1 nav-link text-light" style="font-weight: bold;">Insert Courses</a></button>
            <button class="p1 btn btn-light btn-responsive mb-2"><a href="adminPanel.php?viewCourse" class="p1 nav-link text-light" style="font-weight: bold;">View Courses</a></button>
            <button class="p1 btn btn-light btn-responsive mb-2"><a href="adminPanel.php?insertTool" class="p1 nav-link text-light" style="font-weight: bold;">Insert Tool</a></button>
            <button class="p1 btn btn-light btn-responsive mb-2"><a href="adminPanel.php?viewTool" class="p1 nav-link text-light" style="font-weight: bold;">View Tools</a></button>
            <button class="p1 btn btn-light btn-responsive mb-2"><a href="adminPanel.php?insertStationery" class="p1 nav-link text-light" style="font-weight: bold;">Insert Stationery</a></button>
            <button class="p1 btn btn-light btn-responsive mb-2"><a href="adminPanel.php?viewStationery" class="p1 nav-link text-light" style="font-weight: bold;">View Stationery</a></button>
            <button class="p1 btn btn-light btn-responsive mb-2"><a href="adminPanel.php?listOrders" class="p1 nav-link text-light" style="font-weight: bold;">All Orders</a></button>
            <button class="p1 btn btn-light btn-responsive mb-2"><a href="adminPanel.php?listPayments" class="p1 nav-link text-light" style="font-weight: bold;">All Payments</a></button>
            <button class="p1 btn btn-light btn-responsive mb-2"><a href="adminPanel.php?listUsers" class="p1 nav-link text-light" style="font-weight: bold;">List Users</a></button>
            <button class="p1 btn btn-light btn-responsive mb-2"><a href="adminPanel.php?listMessages" class="p1 nav-link text-light" style="font-weight: bold;">User Messages</a></button>
            <button class="p1 btn btn-danger btn-responsive mb-2"><a href="./adminLogin.php" class="p1 nav-link text-light" style="font-weight: bold;">Logout</a></button>
        </div>
    </div>
</div>


        <!-- fourth child -->
        <div class="p1 container my-3">
            <?php
                if(isset($_GET['insertBook'])){
                    include('insertBook.php');
                }
                if(isset($_GET['insertCourse'])){
                    include('insertCourses.php');
                }
                if(isset($_GET['viewBook'])){
                    include('viewBook.php');
                }
                if(isset($_GET['editBook'])){
                    include('editBook.php');
                }
                if(isset($_GET['deleteBook'])){
                    include('deleteBook.php');
                }
                if(isset($_GET['viewCourse'])){
                    include('viewCourse.php');
                }
                if(isset($_GET['editCourse'])){
                    include('editCourse.php');
                }
                if(isset($_GET['deleteCourse'])){
                    include('deleteCourse.php');
                } 
                if(isset($_GET['listOrders'])){
                    include('listOrders.php');
                }
                if(isset($_GET['deleteOrders'])){
                    include('deleteOrders.php');
                }
                if(isset($_GET['listPayments'])){
                    include('listPayments.php');
                }
                if(isset($_GET['listUsers'])){
                    include('listUsers.php');
                }
                if(isset($_GET['listMessages'])){
                    include('listMessages.php');
                }
            ?>
        </div>

        <div class="p1 container my-3">
            <?php
                if(isset($_GET['insertTool'])){
                    include('insertTool.php');
                }
                if(isset($_GET['insertStationery'])){
                    include('insertStationery.php');
                }
                if(isset($_GET['viewTool'])){
                    include('viewTool.php');
                }
                if(isset($_GET['editTool'])){
                    include('editTool.php');
                }
                if(isset($_GET['deleteTool'])){
                    include('deleteTool.php');
                }
                if(isset($_GET['viewStationery'])){
                    include('viewStationery.php');
                }
                if(isset($_GET['editStationery'])){
                    include('editStationery.php');
                }  
                if(isset($_GET['deleteStationery'])){
                    include('deleteStationery.php');
                }        
            ?>
        </div>
        </div>
    </div>


     <!-- bootstrap js link-->
     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>
