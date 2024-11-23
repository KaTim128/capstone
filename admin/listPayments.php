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
            background-color: #f8f9fa;
        }
        h3 {
            margin-top: 20px;
        }
        .table-container {
            overflow-x: auto; /* Enables horizontal scrolling */
            margin-top: 30px;
        }
        .table {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table th {
            background-color: #92c85c;
            color: black;
        }
        .table td {
            vertical-align: middle;
        }
        .modal-body {
            text-align: center;
        }
    </style>
</head>
<body>
   <h4 class="p1 text-center text-success" style="overflow:hidden">All Payments</h4>
   <div class="p1 container table-container">
       <table class="p1 table table-bordered table-striped">
           <thead>
               <?php
               $get_payments = "SELECT * FROM `user_payments`";
               $result = mysqli_query($conn, $get_payments);
               $row_count = mysqli_num_rows($result);
               
               if ($row_count == 0) {
                echo "<div class='alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>There are no payments yet.</div>";
               } else {
                   echo "<tr class='text-center'>
                   <th class='p1'>S/N</th>
                   <th class='p1'>Amount</th>
                   <th class='p1'>Invoice Number</th> 
                   <th class='p1'>Payment Method</th>           
                   <th class='p1'>Payment Date</th>
                   <th class='p1'>Delete</th>
               </tr>
               </thead>
               <tbody class='bg-secondary text-light'>";
                   $number = 0;
                   while ($row_data = mysqli_fetch_assoc($result)) {
                       $payment_id = $row_data['payment_id'];
                       $amount_due = $row_data['amount'];
                       $invoice_number = $row_data['invoice_number'];
                       $payment_mode = $row_data['payment_mode'];
                       $payment_date = $row_data['payment_date'];
                       $number++;
                       echo "<tr>
                           <td class='p1 text-center'>$number</td>
                           <td class='p1 text-center'>$amount_due</td>
                           <td class='p1 text-center'>$invoice_number</td> 
                           <td class='p1 text-center'>$payment_mode</td>
                           <td class='p1 text-center'>$payment_date</td>
                           <td class='p1 text-center'><a href='#' class='text-light' data-toggle='modal' data-target='#deleteModal' onclick='setpaymentId($payment_id)'><i class='fa-solid fa-trash'></i></a></td>
                       </tr>";
                   }
               }
               ?>    
           </tbody>
       </table>
   </div> 

   <!-- Delete Confirmation Modal -->
   <div class="p1 modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
       <div class="p1 modal-dialog" role="document">
           <div class="p1 modal-content">
               <div class="p1 modal-body">
                   <h6 style="overflow:hidden;">Are you sure you would like to delete this payment?</h6>
               </div>
               <div class="p1 modal-footer">
                   <button type="button" class="p1 btn btn-secondary" data-dismiss="modal">No</button>
                   <button type="button" class="p1 btn btn-danger" id="confirmDeletePayment">Yes, Delete</button>
               </div>
           </div>
       </div>
   </div>

   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0T7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
   <script>
       let paymentId = null;

       function setpaymentId(id) {
           paymentId = id;
       }

       document.getElementById('confirmDeletePayment').addEventListener('click', function() {
           if (paymentId) {
               window.location.href = `deletePayments.php?deletePayments=${paymentId}`;
           }
       });
   </script>
</body>
</html>
