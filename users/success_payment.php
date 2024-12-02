<?php
// payment_success.php
if (isset($_GET['invoice_number'])) {
    $invoice_number = htmlspecialchars($_GET['invoice_number']);
} else {
    header("Location: profile.php"); // Redirect if no invoice number is provided
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print N Pixel</title>
    <link rel="icon" type="image/png" href="./images/logo_new.png">
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #e0f7fa; /* Light cyan background */
            font-family: "Fredericka the Great", "cursive";
        }
        .confirmation-message {
            text-align: center;
            padding: 40px;
            border-radius: 12px;
            background-color: white;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 90%; /* Responsive width */
            max-width: 500px; /* Maximum width */
        }
        h2 {
            font-size: 2.5em; /* Larger heading */
            color: #00796b; /* Teal color for the heading */
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2em; /* Increased paragraph font size */
            color: #555; /* Darker text color */
            margin: 10px 0;
        }
        strong {
            color: #d32f2f; /* Red color for the invoice number */
            font-size: 1.4em; /* Larger invoice number */
        }
        /* Add a transition for the confirmation message */
        .confirmation-message {
            opacity: 0;
            animation: fadeIn 0.5s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body class="green">
    <div class="confirmation-message">
        <h2 class="p1">Payment Confirmed!</h2>
        <p class="p1">Your invoice number is: <strong><?php echo $invoice_number; ?></strong></p>
        <p class="p1">You will be redirected to your profile shortly...</p>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = 'profile.php?orders';
        }, 2000);
    </script>
</body>
</html>
