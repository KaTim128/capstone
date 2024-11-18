<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <h4 class="text-center text-success" style="overflow:hidden">All Contact Messages</h4>

    <!-- Table container with horizontal scroll -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-color">
                <?php
                $get_contacts = "SELECT * FROM `contacts`";
                $result = mysqli_query($conn, $get_contacts);
                $row_count = mysqli_num_rows($result);
                
                if ($row_count == 0) {
                    echo "<div class='alert alert-warning text-center mt-5' style='margin: 0 auto; width: fit-content;'>There are no contact messages yet.</div>";
                } else {
                    echo "<tr class='text-center'>
                    <th>S1 no</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody class='bg-secondary text-light text-center'>";
                    $number = 0;
                    while ($row_data = mysqli_fetch_assoc($result)) {
                        $contact_id = $row_data['contact_id']; // Make sure contact_id exists in the database
                        $name = $row_data['name'];
                        $email = $row_data['email'];
                        $message = $row_data['message'];
                        $number++;
                        echo "<tr>
                            <td>$number</td>
                            <td>$name</td>
                            <td>$email</td>
                            <td>$message</td>
                            <td><a href='#' class='text-light' data-toggle='modal' data-target='#deleteModal' 
                            onclick='setContactId($contact_id)'><i class='fa-solid fa-trash'></i></a></td>
                        </tr>";
                    }
                }
                ?>    
            </tbody>
        </table> 
    </div> <!-- End of table-responsive div -->

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h6>Are you sure you would like to delete this contact message?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteContact">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        let contactId = null;

        function setContactId(id) {
            contactId = id; 
        }

        document.getElementById('confirmDeleteContact').addEventListener('click', function() {
            if (contactId) {
                window.location.href = `deleteContact.php?deleteContact=${contactId}`;
            }
        });
    </script>
</body>
</html>
