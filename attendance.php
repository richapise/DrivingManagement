<?php
session_start();

// Include database connection
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

// Fetch assigned learners with their attendance data for the specified date
$date = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d'); // Default to today's date if not set

$user_id = $_SESSION['user_id'];
$query = "SELECT DISTINCT u.id, u.username, a.status, a.date
          FROM user_table u
          INNER JOIN user_instructor ui ON u.id = ui.user_id
          LEFT JOIN attendance a ON u.id = a.learner_id AND a.date = ?
          WHERE ui.instructor_id = ?
          GROUP BY u.id, u.username, a.date
          ORDER BY a.date ASC";

$stmt = $conn->prepare($query);

// Check if prepare() succeeded
if (!$stmt) {
    die('MySQL prepare() failed: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param("si", $date, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$assigned_learners = $result->fetch_all(MYSQLI_ASSOC); // Fetch assigned learners with attendance data

// Handle form submission to update attendance
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST['status'] as $learner_id => $status) {
        // Update or insert attendance record
        $query = "REPLACE INTO attendance (learner_id, date, status) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);

        // Check if prepare() succeeded
        if (!$stmt) {
            die('MySQL prepare() failed: ' . htmlspecialchars($conn->error));
        }

        $stmt->bind_param("iss", $learner_id, $date, $status);
        $stmt->execute();
    }
    // Redirect or show success message
    header("Location: attendance.php"); // Redirect to prevent form resubmission
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input[type="date"] {
            max-width: 250px;
            margin-bottom: 20px;
        }
        .form-control, select {
            border-radius: 10px;
            padding: 10px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table thead th {
            background-color: #6f42c1;
            color: white;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #6f42c1;
            border: none;
        }
        .btn-primary:hover {
            background-color: #5a2a8f;
        }
        .btn-back {
            background-color:  #6f42c1; /* Set button color to pink */
            color: white;
            margin-top: 20px;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Set the min attribute to today's date
            var today = new Date().toISOString().split('T')[0];
            document.getElementById("date").setAttribute('min', today);
            document.getElementById("date").setAttribute('value', today); // Set default value to today's date
        });
    </script>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Mark Attendance</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="mb-4">
            <div class="form-group">
                <label for="date">Select Date:</label>
                <input type="date" id="date" name="date" class="form-control" required value="<?php echo $date; ?>">
            </div>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="text-center">
                        <th>Username</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($assigned_learners as $learner): ?>
                        <?php
                        // Set default status to 'Present' if nothing is posted
                        $learner_id = $learner['id'];
                        $attendance_status = isset($_POST['attendance_status'][$learner_id]) ? $_POST['attendance_status'][$learner_id] : 'Present';
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($learner['username']); ?></td>
                            <td>
                                <select name="attendance_status[<?php echo htmlspecialchars($learner_id); ?>]" class="form-select">
                                    <option value="Present" <?php echo ($attendance_status == 'Present') ? 'selected' : ''; ?>>Present</option>
                                    <option value="Absent" <?php echo ($attendance_status == 'Absent') ? 'selected' : ''; ?>>Absent</option>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit Attendance</button>
            </div>
        </form>
        <div class="button-container">
        <a href="instructor_dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>
    </div>
</body>
</html>
