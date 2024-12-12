<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print N Pixel</title>
    <link rel="icon" type="image/png" href="../images/logo_new.png">
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
    </style>
</head>
<body class=" p1 green">
    <div class=" p1 confirmation-message">
        <h2 class="p1">Account Deleted Successfully!</h2>
        <p class="p1">Your account has been successfully deleted.</p>
        <p class="p1">You will be redirected to the main page shortly...</p>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = '../index.php'; // Redirect to main page
        }, 2000);
    </script>
</body>
</html>
