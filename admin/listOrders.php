<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <h4 class="text-center text-success" style="overflow:hidden">All Orders</h4>

    <!-- Table container with horizontal scroll -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-color">
                <?php
                $get_orders = "SELECT * FROM `orders`";
                $result = mysqli_query($conn, $get_orders);
                $row_count = mysqli_num_rows($result);
                
                if ($row_count == 0) {
                    echo "<div class='alert alert-warning text-center mt-5' style='margin: 0 auto; width: fit-content;'>There are no orders yet.</div>";
                } else {
                    echo "<tr class='text-center'>
                    <th>S1 no</th>
                    <th>Due Amount</th>
                    <th>Quantity</th>
                    <th>Invoice Number</th>            
                    <th>Order Date</th>
                    <th>Product ID</th>
                    <th>Status</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody class='bg-secondary text-light text-center'>";
                    $number = 0;
                    while ($row_data = mysqli_fetch_assoc($result)) {
                        $order_id = $row_data['order_id'];
                        $user_id = $row_data['user_id'];
                        $amount_due = $row_data['amount_due'];
                        $quantity = $row_data['quantity'];
                        $invoice_number = $row_data['invoice_number'];
                        $book_id = $row_data['book_id'];
                        $tool_id = $row_data['tool_id'];
                        $order_date = $row_data['order_date'];
                        $order_status = $row_data['order_status'];
                        $number++;
                        echo "<tr>
                            <td>$number</td>
                            <td>$amount_due</td>
                            <td>$quantity</td>
                            <td>$invoice_number</td>
                            <td>$order_date</td>";

                        // Check if book_id or tool_id should be displayed in the Product ID column
                        if (!empty($book_id)) {
                            echo "<td>$book_id</td>";
                        } else {
                            echo "<td>$tool_id</td>";
                        }

                        // Continue with the rest of the row
                        echo "<td>$order_status</td>
                            <td><a href='#' class='text-light' data-toggle='modal' data-target='#deleteModal' onclick='setOrderId($order_id)'><i class='fa-solid fa-trash'></i></a></td>
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
                    <h6>Are you sure you would like to delete this order?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteOrder">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        let orderId = null;

        function setOrderId(id) {
            orderId = id; 
        }

        document.getElementById('confirmDeleteOrder').addEventListener('click', function() {
            if (orderId) {
                window.location.href = `deleteOrders.php?deleteOrders=${orderId}`;
            }
        });
    </script>
</body>
</html>
