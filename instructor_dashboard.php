<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

// Include database connection or any necessary files
include "db.php"; // Example inclusion of database connection file

// Fetch instructor data
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM instructors WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$instructor_data = $result->fetch_assoc();

// Initialize message variables
$success_message = '';
$slot_message = '';

// Example logic to set these messages based on conditions
// You can replace this with your actual logic to set these messages
if (isset($_SESSION['success'])) {
    $success_message = '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']); // Clear the message after displaying
}

if (isset($_SESSION['slot_message'])) {
    $slot_message = '<div class="alert alert-info">' . $_SESSION['slot_message'] . '</div>';
    unset($_SESSION['slot_message']); // Clear the message after displaying
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: white;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: #007bff;
            color: white;
            padding-top: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 15px 20px;
            font-weight: 700;
        }

        .sidebar a:hover {
            background-color: #0056b3;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dashboard-header h2 {
            margin: 0;
            color: #007bff;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .nav-item a {
            margin-left: 20px;
            color: #007bff;
            font-weight: 700;
        }

        /* New layout styles */
        .row {
            display: flex;
        }

        .image-section {
            flex: 1;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-section img {
            max-width: 100%;
            height: auto;
        }

        .cards-section {
            flex: 2;
            padding-left: 20px;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h4 class="text-center">Instructor Dashboard</h4>
        <a href="view_assigned_learner.php">View Learners</a>
        <a href="view_assigned_slots.php">Assign Slots</a>
        <a href="attendance.php">Attendance</a>
        <a href="apply_leave.php">Apply Leave</a>
        <a href="upload_license.php">Upload License</a>
        <a href="certificate.php">Generate certificate</a>
        <a href="progress.php">Check Progress</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <div class="dashboard-header">
            <h2>Welcome, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Instructor'; ?>!</h2>
            <!-- Displayed Messages -->
            <?php echo $success_message; ?>
            <?php echo $slot_message; ?>
        </div>

        <div class="row">
            <!-- Image on the left side -->
            <div class="image-section">
                <img src="https://img.freepik.com/free-vector/cute-happy-smiling-child-isolated-white_1308-32243.jpg?t=st=1726463567~exp=1726467167~hmac=e840f0f364fc6fe1ad191c6f5446c8ad063f5f3567d963dbf9684f33f03e7b93&w=360" alt="Instructor Image">
            </div>

            <!-- Cards on the right side -->
            <div class="cards-section">
                <!-- Assigned Learners Card -->
                <div class="card">
                    <div class="card-header">
                        Assigned Learners
                    </div>
                    <div class="card-body">
                        You are currently assigned to 2 learners. Check their progress regularly.
                    </div>
                </div>

                <!-- Schedule Overview -->
                <div class="card">
                    <div class="card-header">
                        Upcoming Lessons
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Lesson with Hrishi: 15th September, 2024</li>
                            <li>Lesson with Richa: 17th September, 2024</li>
                        </ul>
                    </div>
                </div>

                <!-- Performance Overview -->
                <div class="card">
                    <div class="card-header">
                        Feedback from Learners
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Richa: "Great instructor!"</li>
                            <li>Hrishi: "Very helpful lessons."</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-L0tfVL2/T3LQ7y9oDKF5s/zhoPe6MGtohHwUrBcBzL4NprJh95S9IxWWJ2jt/aXr" crossorigin="anonymous"></script>
</body>
</html>
