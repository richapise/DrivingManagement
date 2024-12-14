<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
        }

        .top-nav {
            background-color: #fff;
            padding: 10px;
            display: flex;
            justify-content: flex-end;
        }

        .top-nav a {
            color: black;
            text-decoration: none;
            margin-left: 20px;
            font-weight: 700;
        }

        .content {
            display: flex;
            justify-content: center; /* Centers the content */
            align-items: center;
            margin-top: 100px;
            padding: 20px;
            gap: 20px; /* Adds space between the image and the text */
        }

        .text-content {
            max-width: 500px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center; /* Centers the text */
        }

        .text-content h1 {
            font-size: 2.2rem;
            margin-bottom: 15px;
            color: #ff5a5f;
        }

        .text-content p {
            font-size: 1.2rem;
            margin-bottom: 25px;
        }

        .text-content a {
            text-decoration: none;
            background-color: #ff5a5f;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            font-size: 18px;
        }

        .text-content a:hover {
            background-color: #0056b3;
        }

        .image-content {
            max-width: 500px; /* Reduced the width */
        }

        .image-content img {
            max-width: 100%;
            height: auto;
           
        }
        .btn-back {
            background-color: #ff5a5f; /* Set button color to pink */
            color: white;
            margin-top: -140px;
        }
    </style>
</head>
<body>
    <div class="top-nav">
        <a href="Home.php">Home</a>
        <a href="login_form.php">Login</a>
        <a href="dashboard.php">Learner Dashboard</a>
        <a href="feedback.php">Feedback</a>
    </div>

    <div class="content">
        <div class="text-content">
            <h1>Make a Payment</h1>
            <p>Click the button below to make a secure payment via Razorpay.</p>
            <a href="https://razorpay.me/@richadineshpise" target="_blank">Pay Now</a>
        </div>
        
        <div class="image-content">
            <img src="https://img.freepik.com/free-vector/credit-card-concept-illustration_114360-170.jpg?ga=GA1.1.114055217.1709874952" alt="Mobile Payment Image">
        </div>
        
    </div>
    <div class="button-container">
        <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>
</body>
</html>
