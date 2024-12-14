<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

// Include database connection or any necessary files
include "db.php"; // Example inclusion of database connection file

// Fetch users associated with the instructor
$user_id = $_SESSION['user_id'];
$query = "SELECT u.* FROM user_table u
          INNER JOIN user_instructor ui ON u.id = ui.user_id
          WHERE ui.instructor_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$assigned_learners = $result->fetch_all(MYSQLI_ASSOC); // Assign fetched users to $assigned_learners

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Learners</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        /* Custom CSS */
        body, html {
            height: 100%;
            margin: 0;
        }

        .flex-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
            background-color: #f4f4f4;
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
        }

        .top-image {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px; /* Space between image and cards */
        }

        /* Style for highlighted learner names */
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #6f42c1; /* Highlight color */
            background-color: #f0e8ff; /* Light background for emphasis */
            padding: 10px;
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #6f42c1; /* Adjusted button color to match */
        }
    </style>
</head>
<body>
    <div class="flex-container">
        <div class="container">
            <!-- Image at the top -->
            <img src="https://img.freepik.com/free-photo/3d-portrait-happy-friends_23-2150793901.jpg?ga=GA1.1.114055217.1709874952&semt=ais_hybrid" class="top-image" alt="Assigned Learners">

            <h1>Assigned Learners</h1>
            <div class="row">
                <?php foreach ($assigned_learners as $learner): ?>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($learner['username']); ?></h5>
                                <p class="card-text">Email: <?php echo htmlspecialchars($learner['email']); ?></p>
                                <!-- Add more details as needed -->
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="instructor_dashboard.php" class="btn btn-primary mt-3">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
