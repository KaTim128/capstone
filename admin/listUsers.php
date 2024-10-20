<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa; /* Light background for better contrast */
        }
        h3 {
            margin-top: 20px; /* Add some space above the heading */
        }
        .table {
            margin-top: 30px; /* Add some space above the table */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
        }
        .table th {
            background-color: #17a2b8; /* Bootstrap info color */
            color: white;
        }
        .table td {
            vertical-align: middle; /* Center-align table cells */
        }
        .modal-body {
            text-align: center; /* Center text in the modal */
        }
        .user-image {
            width: 50px; /* Set the width of the image */
            height: 50px; /* Set the height of the image */
            object-fit: cover; /* Ensures the image covers the space without distortion */
            border-radius: 50%; /* Optional: makes the image round */
        }
    </style>
</head>
<body>
   <h3 class="text-center text-success" style="overflow:hidden">All Users</h3>
   <div class="container">
       <table class="table table-bordered table-striped mt-5">
           <thead>
               <?php
               $get_users = "SELECT * FROM `user`";
               $result = mysqli_query($conn, $get_users);
               $row_count = mysqli_num_rows($result);
               
               if ($row_count == 0) {
                echo "<div class='alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>There are no users yet.</div>";
               } else {
                   echo "<tr class='text-center'>
                   <th>S/N</th>
                   <th>Username</th>
                   <th>User Email</th> 
                   <th>User Image</th>           
                   <th>User Address</th>
                   <th>User Mobile</th>
                   <th>Delete</th>
               </tr>
               </thead>
               <tbody class='bg-secondary text-light'>";
                   $number = 0;
                   while ($row_data = mysqli_fetch_assoc($result)) {
                       $user_id = $row_data['user_id'];
                       $username = $row_data['user_username'];
                       $email = $row_data['user_email'];
                       $image = $row_data['user_image'];
                       $address = $row_data['user_address'];
                       $contact = $row_data['user_contact'];
                       $number++;
                       echo "<tr>
                           <td class='text-center'>$number</td>
                           <td class='text-center'>$username</td>
                           <td class='text-center'>$email</td>
                           <td class='text-center'><img src='../users/user_images/$image' alt='$username' class='user-image'/></td> 
                           <td class='text-center'>$address</td>
                           <td class='text-center'>$contact</td>
                           <td class='text-center'><a href='#' class='text-light' data-toggle='modal' data-target='#deleteModal' onclick='setUserId($user_id)'><i class='fa-solid fa-trash'></i></a></td>
                       </tr>";
                   }
               }
               ?>    
           </tbody>
       </table>
   </div> 

   <!-- Delete Confirmation Modal -->
   <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-body">
                   <h6>Are you sure you would like to delete this user?</h6>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                   <button type="button" class="btn btn-danger" id="confirmDeleteUser">Yes, Delete</button>
               </div>
           </div>
       </div>
   </div>

   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
   <script>
       let userId = null;

       function setUserId(id) {
           userId = id;
       }

       document.getElementById('confirmDeleteUser').addEventListener('click', function() {
           if (userId) {
               window.location.href = `deleteUsers.php?deleteUsers=${userId}`;
           }
       });
   </script>
</body>
</html>
