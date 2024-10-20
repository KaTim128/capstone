<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <h3 class="text-center text-success" style="overflow:hidden">All Orders</h3>
<table class="table table-bordered mt-5">
    <thead class="bg-info">
        <?php
        $get_orders = "SELECT * FROM `orders`";
        $result = mysqli_query($conn, $get_orders);
        $row_count = mysqli_num_rows($result);
        
        if ($row_count == 0) {
            echo "<div class='alert alert-warning text-center mt-4' style='margin: 0 auto; width: fit-content;'>There are no orders yet.</div>";
        } else {
            echo "<tr>
            <th>S1 no</th>
            <th>Due Amount</th>
            <th>Total Products</th>
            <th>Invoice Number</th>            
            <th>Order Date</th>
            <th>Status</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody class='bg-secondary text-light'>";
            $number = 0;
            while ($row_data = mysqli_fetch_assoc($result)) {
                $order_id = $row_data['order_id'];
                $user_id = $row_data['user_id'];
                $amount_due = $row_data['amount_due'];
                $total_products = $row_data['total_products'];
                $invoice_number = $row_data['invoice_number'];
                $order_date = $row_data['order_date'];
                $order_status = $row_data['order_status'];
                $number++;
                echo "<tr>
                    <td>$number</td>
                    <td>$amount_due</td>
                    <td>$total_products</td>
                    <td>$invoice_number</td>
                    <td>$order_date</td>
                    <td>$order_status</td>
                    <td><a href='#' class='text-light' data-toggle='modal' data-target='#deleteModal' onclick='setOrderId($order_id)'><i class='fa-solid fa-trash'></i></a></td>
                </tr>";
            }
        }
        ?>    
    </tbody>
</table> 
</body>
</html>


<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h6>Are you sure you would like to delete this order?</h6>
            </div>
            <div class="modal-footer">
                <!-- No button, just closes modal -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <!-- Yes button, triggers the deletion -->
                <button type="button" class="btn btn-danger" id="confirmDeleteOrder">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript to store order ID for deletion
    let orderId = null;

    function setOrderId(id) {
        orderId = id; // Store the order ID when delete button is clicked
    }

    // Handle delete confirmation
    document.getElementById('confirmDeleteOrder').addEventListener('click', function() {
        if (orderId) {
            // Redirect to PHP delete action with the order_id
            window.location.href = `deleteOrders.php?deleteOrders=${orderId}`;
        }
    });
</script>
