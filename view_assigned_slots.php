<?php
session_start();

// Include database connection
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

// Fetch assigned slots with learner details
$instructor_id = $_SESSION['user_id'];
$query = "SELECT s.*, u.username AS learner_username, u.email AS learner_email
          FROM slots s
          INNER JOIN user_table u ON s.user_id = u.id
          INNER JOIN user_instructor ui ON s.user_id = ui.user_id
          WHERE ui.instructor_id = ?";
$stmt = $conn->prepare($query);

// Check if prepare() succeeded
if (!$stmt) {
    die('MySQL prepare() failed: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param("i", $instructor_id);
$stmt->execute();
$result = $stmt->get_result();
$assigned_slots = $result->fetch_all(MYSQLI_ASSOC);

// Close statement and connection
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Assigned Slots</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #CF9FFF;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
        }
        .card {
            margin-bottom: 20px;
            border: 2px solid #6f42c1; /* Border color */
            border-radius: 15px; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0,0,0,0.2); /* Shadow effect */
        }
        .card-header {
            background-color: #6f42c1; /* Header background color */
            color: white;
            font-size: 1.25rem;
            border-bottom: 2px solid #5a2a8f; /* Header border color */
            border-top-left-radius: 15px; /* Rounded corners for header */
            border-top-right-radius: 15px; /* Rounded corners for header */
        }
        .highlight {
            font-weight: bold;
            color: #6f42c1; /* Highlight color */
        }
        .btn-back {
            background-color:  #6f42c1; /* Set button color to pink */
            color: white;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">View Assigned Slots</h1>
        <?php if (empty($assigned_slots)): ?>
            <p class="text-center">No slots assigned to learners yet.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($assigned_slots as $slot): ?>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                Slot Information
                            </div>
                            <div class="card-body">
                                <h5 class="card-title highlight">Date: <?php echo htmlspecialchars($slot['date']); ?></h5>
                                <p class="card-text highlight">Slot Time: <?php echo htmlspecialchars($slot['time']); ?></p>
                                <p class="card-text">Assigned Learner: <?php echo htmlspecialchars($slot['learner_username']); ?></p>
                                <p class="card-text">Learner Email: <?php echo htmlspecialchars($slot['learner_email']); ?></p>
                                <!-- Add more details as needed -->
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="button-container">
        <a href="instructor_dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>    </div>
</body>
</html>
