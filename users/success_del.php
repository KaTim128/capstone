<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Deletion Successful</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #e0f7fa; /* Light cyan background */
            font-family: 'Arial', sans-serif;
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
<body class="green">
    <div class="confirmation-message">
        <h2>Account Deleted Successfully!</h2>
        <p>Your account has been successfully deleted.</p>
        <p>You will be redirected to the main page shortly...</p>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = '../index.php'; // Redirect to main page
        }, 3000);
    </script>
</body>
</html>
