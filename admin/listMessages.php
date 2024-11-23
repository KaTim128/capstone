<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        /* Added margin to buttons for better spacing */
        .action-buttons button {
            margin-right: 10px; /* Adds space between the buttons */
            margin-bottom: 5px; /* Optional: Adds space below the buttons */
        }
    </style>
</head>
<body>
    <h4 class="p1 text-center text-success" style="overflow:hidden">All Messages</h4>

    <!-- Table container with horizontal scroll -->
    <div class="p1 table-responsive">
        <table class="p1 table table-bordered">
            <thead class="p1 table-color">
                <?php
                $get_msgs = "SELECT * FROM `contacts`";
                $result = mysqli_query($conn, $get_msgs) or die("Query Failed: " . mysqli_error($conn));
                $row_count = mysqli_num_rows($result);
                
                if ($row_count == 0) {
                    echo "<div class='alert alert-warning text-center mt-5' style='margin: 0 auto; width: fit-content;'>There are no messages yet.</div>";
                } else {
                    echo "<tr class='text-center table-color text-dark'>
                    <th class='p1'>S1 no</th>
                    <th class='p1'>Name</th>
                    <th class='p1'>Email</th>
                    <th class='p1'>Reply</th>
                    <th class='p1'>Delete</th>
                </tr>
                </thead>
                <tbody class='bg-secondary text-light text-center'>";

                    $number = 0;
                    while ($row_data = mysqli_fetch_assoc($result)) {
                        $contact_id = $row_data['contact_id']; // Ensure contact_id exists in the database
                        $name = $row_data['name'];
                        $email = $row_data['email'];
                        $message = $row_data['message'];
                        $number++;
                        echo "<tr>
                            <td class='p1'>$number</td>
                            <td class='p1'>$name</td>
                            <td class='p1'>$email</td>
                            <td class='p1'>$message</td>
                            <td class='action-buttons'>
                                <button class='p1 btn btn-style' data-toggle='modal' data-target='#replyModal' onclick='setReplyDetails($contact_id, \"$email\")'>Reply</button>
                                <button class='p1 btn btn-danger' data-toggle='modal' data-target='#deleteModal' onclick='setContactId($contact_id)'>Delete</button>
                            </td>   
                        </tr>";
                    }
                    echo "</tbody>"; // Close tbody after the loop ends
                }
                ?>    
            </table> 
        </div>

    <!-- Delete Confirmation Modal -->
    <div class="p1 modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="p1 modal-dialog" role="document">
            <div class="p1 modal-content">
                <div class="p1 modal-body">
                    <h6 style="overflow:hidden;">Are you sure you would like to delete this message?</h6>
                </div>
                <div class="p1 modal-footer">
                    <button type="button" class="p1 btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="p1 btn btn-danger" id="confirmDeleteOrder" onclick="deleteMessage()">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reply Modal -->
<div class="p1 modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="p1 modal-dialog" role="document">
        <div class="p1 modal-content">
            <div class="p1 modal-header">
                <h5 class="p1 modal-title" id="replyModalLabel">Reply to User</h5>
                <button type="button" class="p1 close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="p1 modal-body">
                <input type="hidden" name="contact_id" id="reply_contact_id">
                <input type="hidden" name="email" id="reply_email">
                <div class="p1 form-group">
                    <label for="replyMessage">Message</label>
                    <textarea class="p1 form-control" name="replyMessage" id="replyMessage" rows="4" required></textarea>
                </div>
            </div>
            <div class="p1 modal-footer">
                <button type="button" class="p1 btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="p1 btn btn-style" onclick="sendReply()">Send Reply</button>
            </div>
        </div>
    </div>
</div>

    <!-- Hidden Form for Deleting -->
    <form id="deleteForm" action="deleteContact.php" method="POST" style="display:none;">
        <input type="hidden" name="contact_id" id="contact_id">
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <script>
    let contactId = null;

    function setContactId(id) {
        contactId = id; 
    }

    function deleteMessage() {
        if (contactId) {
            // Redirect to deleteContact.php with the contact ID as a GET parameter
            window.location.href = `deleteContact.php?deleteContact=${contactId}`;
        }
    }

    function setReplyDetails(id, email) {
    document.getElementById('reply_contact_id').value = id;
    document.getElementById('reply_email').value = email;
}

function sendReply() {
    // Get the values from the modal inputs
    const contactId = document.getElementById('reply_contact_id').value;
    const email = document.getElementById('reply_email').value;
    const message = document.getElementById('replyMessage').value;

    if (message.trim() === '') {
        alert('Reply message cannot be empty.');
        return;
    }

    // Simulate sending the message
    console.log(`Reply Sent: Contact ID: ${contactId}, Email: ${email}, Message: ${message}`);

    // Close the modal
    $('#replyModal').modal('hide');

    // Show a success message and then redirect
    setTimeout(() => {
        alert('Reply sent successfully!');
        // Redirect back to the admin panel
        window.location.href = 'adminPanel.php';
    }, 500);

    // Clear the form fields
    document.getElementById('reply_contact_id').value = '';
    document.getElementById('reply_email').value = '';
    document.getElementById('replyMessage').value = '';
}

</script>

</body>
</html>
