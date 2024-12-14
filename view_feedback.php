<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: white;
            font-family: 'Roboto', sans-serif;
        }

        .main-content {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            min-height: 100vh;
            padding: 50px;
        }

        .left-image {
            flex: 0 0 200px; /* Fixed width for the image section */
            margin-right: 30px; /* Space between the image and container */
        }

        .left-image img {
            width: 500px;
            height: 400px;
            border-radius: 8px; /* Slightly rounded corners */
        }

        .container {
            flex: 1; /* The container will take the remaining space */
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card {
            margin: 10px 0;
            border: 1px solid #d5006d;
            border-radius: 8px;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #d5006d;
            background-color: #f8d3e6;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }

        .card-body {
            background-color: #ffffff;
            padding: 15px;
        }

        .card-footer {
            background-color: #f8d3e6;
            padding: 10px;
            border-radius: 0 0 8px 8px;
        }

        .btn-primary {
            background-color: #d5006d;
            border: none;
        }

        .btn-primary:hover {
            background-color: #a30045;
        }

        .back-btn {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <!-- Left Image Section -->
        <div class="left-image">
            <img src="https://img.freepik.com/free-vector/pink-empty-paper-with-businessman-carrying-some-documents_1308-32753.jpg?t=st=1728140000~exp=1728143600~hmac=e75ddebbbff608c6d8aa9f54ffc20667acb75e80a7dec6b0cdab829a6c84c9b1&w=826" alt="Left Side Image">
        </div>

        <!-- Main Container for Feedback -->
        <div class="container">
            <h1 class="text-center text-danger mb-4">View Feedback</h1>
            <div class="row">
                <?php
                // Include database connection
                include "db.php"; // Assuming db.php contains your database connection logic

                // Fetch feedback data from the database
                $query = "SELECT * FROM feedback"; // Query to fetch all feedback records
                $result = $conn->query($query);

                // Check if there are any feedback records
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-6">'; // Adjusted to 6 for better layout
                        echo '<div class="card">';
                        echo '<div class="card-title">' . htmlspecialchars($row['name']) . '</div>'; // Display name
                        echo '<div class="card-body">';
                        echo '<p>Email: ' . htmlspecialchars($row['email']) . '</p>'; // Display email
                        echo '<p>Feedback: ' . htmlspecialchars($row['feedback']) . '</p>'; // Display feedback message
                        echo '</div>';
                        echo '<div class="card-footer"></div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No feedback available.</p>'; // Display message if no feedback records found
                }

                // Close the database connection
                $conn->close();
                ?>
            </div>

            <!-- Back to Dashboard Button -->
            <div class="back-btn">
                <a href="admin_dashboard.php" class="btn btn-primary">Back to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
