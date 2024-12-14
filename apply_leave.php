<?php
session_start();
include 'db.php'; // Include your database connection file

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure instructor_id is available in session
    if (!isset($_SESSION['instructor_id'])) {
        die("Session expired or instructor not logged in.");
    }
    
    // Retrieve form data
    $instructor_id = $_SESSION['instructor_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $reason = $_POST['reason'];


    // Insert leave application into database
    $query = "INSERT INTO leave_applications (instructor_id, start_date, end_date, reason) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("isss", $instructor_id, $start_date, $end_date, $reason);
        if ($stmt->execute()) {
            // Leave application submitted successfully
            $success_message = "Leave application submitted successfully.";
        } else {
            // Failed to execute the statement
            $error_message = "Failed to submit leave application. Error: " . $conn->error;
        }
        // Close the statement
        $stmt->close();
    } else {
        // Error preparing the statement
        $error_message = "Error preparing SQL statement. Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Leave Application</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h2 {
            font-weight: bold;
            color: #6f42c1;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: 500;
            color: #333;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px;
            font-size: 16px;
        }
        .btn-submit {
            background-color: #6f42c1;
            color: #fff;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
        .alert {
            font-size: 14px;
            margin-bottom: 20px;
        }
        .btn-back {
            background-color: #6f42c1; /* Set button color to pink */
            color: white;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Apply for Leave</h2>
        <!-- Success or Error message -->
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success text-center" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php elseif (isset($error_message)): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <!-- Leave Application Form -->
        <form action="apply_leave.php" method="POST">
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="reason">Reason for Leave:</label>
                <textarea id="reason" name="reason" rows="4" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-submit">Submit</button>
        </form>
    </div>
    <div class="button-container">
        <a href="instructor_dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
