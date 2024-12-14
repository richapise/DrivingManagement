<?php
session_start();

// Include database connection
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

// Fetch assigned learners with their attendance data and package information
$user_id = $_SESSION['user_id'];
$query = "SELECT u.*, 
                 p.package_name, p.package_duration,
                 COUNT(a.status) AS total_classes, 
                 SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) AS present_count
          FROM user_table u
          INNER JOIN user_instructor ui ON u.id = ui.user_id
          LEFT JOIN user_package_selections ups ON u.id = ups.user_id  -- Join with user_package_selections
          LEFT JOIN packages p ON ups.package_id = p.id                -- Join with packages table
          LEFT JOIN attendance a ON u.id = a.learner_id
          WHERE ui.instructor_id = ?
          GROUP BY u.id";

$stmt = $conn->prepare($query);

// Check if prepare() succeeded
if (!$stmt) {
    die('MySQL prepare() failed: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$learners = $result->fetch_all(MYSQLI_ASSOC); // Fetch learners with attendance data

// Helper function to convert package duration to days
function getPackageDays($package_duration) {
    switch ($package_duration) {
        case '1 Year': return 365;
        case '6 Months': return 180;
        case '3 Months': return 90;
        default: return 0;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learner Progress</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .progress {
            height: 30px;
        }
        .progress-bar {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Learner Progress</h1>
        
        <?php foreach ($learners as $learner): 
            $package_duration_days = getPackageDays($learner['package_duration']);  // Get package duration in days
            $present_count = $learner['present_count'];

            // Calculate progress percentage based on attendance and package duration
            $progress_percentage = $package_duration_days > 0 ? ($present_count / $package_duration_days) * 100 : 0;
        ?>
            <div class="mb-4">
                <h5><?php echo htmlspecialchars($learner['username']); ?></h5>
                <p>Package: <?php echo htmlspecialchars($learner['package_name']); ?> (Duration: <?php echo $learner['package_duration']; ?>)</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $progress_percentage; ?>%; background-color: #6f42c1;" aria-valuenow="<?php echo $progress_percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                        <?php echo round($progress_percentage, 2); ?>%
                    </div>
                </div>
                <p>Total Days in Package: <?php echo $package_duration_days; ?> | Present Days: <?php echo $present_count; ?></p>
            </div>
        <?php endforeach; ?>
        
        <div class="text-center">
            <a href="instructor_dashboard.php" class="btn btn-primary">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
