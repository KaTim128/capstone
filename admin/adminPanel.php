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
    <title>Admin Dashboard</title>
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
            grid-template-columns: repeat(4, 1fr); 
            gap: 15px; 
            width: 100%;
            box-sizing: border-box;
            margin: 5 auto;
            padding: 5px 15px;
            margin-bottom: 5px;
            margin-right:10px;
        }

        /* Media query for mobile devices */
        @media (max-width: 768px) {
            .panel {
                grid-template-columns: repeat(2, 1fr); /* 2 columns on medium screens */
            }
        }

        @media (max-width: 420px) {
            .panel {
                grid-template-columns: 1fr; /* 1 column on small screens */
                padding: 5px; /* Adjust padding for smaller screens */
            }
            .btn-responsive {
                font-size: 14px; /* Maintain readability on smaller screens */
                padding: 10px; /* Padding for buttons */
            }
        }

        .panel button {
            background-color: #74b05c; 
            border: none; 
            border-radius: 5px;
            padding: 5px; 
            margin-left: -3px;
            margin-right: 2px;
        }

        .panel a {
            color: white;
            text-decoration: none;
            display: block;
            width: 100%;
            height: 100%;
            text-align: center;
        }

        .panel button:hover {
            background-color: #4a7439; 
        }

        .footer {
    position: relative; /* Change from absolute to relative */
    clear: both;
    width: 100%;
    padding: 10px 0;
    background-color: #f8f9fa; /* Adjust as needed */
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

    </style>
</head>
<body>
    
        <!-- first child -->
        <nav class="navbar navbar-expand-lg navbar-light dark-green">
            <div class="container-fluid">
                
                <nav class="navbar navbar-expand-lg">
                    <ul class="navbar-nav">
                        <li class="nav-item">
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
        <div class="bg-light">
            <h3 class="text-center p-2 mt-2">Manage Details</h3>
        </div>

        <!-- third child -->
        <div class="row">
            <div class="col-md-12 bg-secondary d-flex align-items-center">
                <div class="my-4 " >
                    <a href="#"><img src="../images/logo_new.png" alt="" class="admin-image"></a>
                </div>
                <div class="panel text-center">
                <button><a href="adminPanel.php?insertBook" class="nav-link text-dark green" style="font-weight: bold; text-align: center; display: block;">Insert Book</a></button>
                <button><a href="adminPanel.php?viewBook" class="nav-link text-dark green" style="font-weight: bold; text-align: center; display: block;">View Books</a></button>
                <button><a href="adminPanel.php?insertCourse" class="nav-link text-dark green" style="font-weight: bold; text-align: center; display: block;">Insert Courses</a></button>
                <button><a href="adminPanel.php?viewCourse" class="nav-link text-dark green" style="font-weight: bold; text-align: center; display: block;">View Courses</a></button>
                <button><a href="adminPanel.php?insertTool" class="nav-link text-dark green" style="font-weight: bold; text-align: center; display: block;">Insert Tool</a></button>
                <button><a href="adminPanel.php?viewTool" class="nav-link text-dark green" style="font-weight: bold; text-align: center; display: block;">View Tools</a></button>
                <button><a href="adminPanel.php?insertStationery" class="nav-link text-dark green" style="font-weight: bold; text-align: center; display: block;">Insert Stationery</a></button>
                <button><a href="adminPanel.php?viewStationery" class="nav-link text-dark green" style="font-weight: bold; text-align: center; display: block;">View Stationery</a></button>
                <button><a href="adminPanel.php?listOrders" class="nav-link text-dark green" style="font-weight: bold; text-align: center; display: block;">All Orders</a></button>
                <button><a href="adminPanel.php?listPayments" class="nav-link text-dark green" style="font-weight: bold; text-align: center; display: block;">All Payments</a></button>
                <button><a href="adminPanel.php?listUsers" class="nav-link text-dark green" style="font-weight: bold; text-align: center; display: block;">List Users</a></button>
                <button><a href="../users/user_login.php" class="nav-link text-dark green" style="font-weight: bold; text-align: center; display: block;">Logout</a></button>
                </div>
            </div>
        </div>

        <!-- fourth child -->
        <div class="container my-3">
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
            ?>
        </div>

        <div class="container my-3">
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

        <!-- last child -->
        <?php getFooter(); ?>
        </div>
    </div>


     <!-- bootstrap js link-->
     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
