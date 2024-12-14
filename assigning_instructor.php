<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigning Instructor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        /* Custom CSS */
        body, html {
            height: 100%;
            margin: 10px;
            background-color: #f4f4f4;
        }

        .flex-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh; /* Full viewport height */
        }

        .container {
            text-align: center;
        }

        .row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .card {
            margin: 10px; /* Margin around each card */
            border: 1px solid #d5006d; /* Dark pink border */
            border-radius: 8px;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #d5006d; /* Dark pink color for title */
            background-color: #f8d3e6; /* Light background for emphasis */
            padding: 20px;
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #d5006d; /* Dark pink button color */
            border: none; /* No border for button */
        }

        .btn-primary:hover {
            background-color: #a30045; /* Darker shade on hover */
        }

        .card-body {
            background-color: #ffffff; /* White background for card body */
        }

        .card-footer {
            background-color: #f8d3e6; /* Light pink background for card footer */
        }
    </style>
</head>
<body>
    <div class="flex-container">
        <div class="container">
            <h1 class="text-danger">Assigning Instructor</h1>
            <div class="row">
                <!-- Loop through instructors fetched from the database -->
                <?php
                // Include database connection
                include "db.php";

                // Fetch instructor data from the database
                $query = "SELECT * FROM instructors"; // Adjust the query according to your database structure
                $result = $conn->query($query);

                // Check if the query was successful
                if ($result && $result->num_rows > 0) {
                    // Loop through each instructor
                    while ($instructor = $result->fetch_assoc()) {
                        echo '<div class="col-md-3">'; // Adjusted to 3 for better layout
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . htmlspecialchars($instructor['username']) . '</h5>';
                        echo '<p class="card-text">Email: ' . htmlspecialchars($instructor['email']) . '</p>';
                        echo '<p class="card-text">Phone: ' . htmlspecialchars($instructor['phone']) . '</p>';
                        // Add more instructor details as needed
                        echo '</div>';
                        echo '<div class="card-footer">';
                        // Add assign button with appropriate functionality
                        echo '<a href="view_learners.php?" class="btn btn-primary">Assign</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-md-12">';
                    echo '<p>No instructors available.</p>';
                    echo '</div>';
                }

                // Close the database connection
                $conn->close();
                ?>
            </div>
            <a href="admin_dashboard.php" class="btn btn-primary mt-3">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
