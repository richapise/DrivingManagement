<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

if (isset($_SESSION['profile_updated'])) {
    $success_message = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                           Profile updated successfully!
                           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                         </div>';
    unset($_SESSION['profile_updated']);
} else {
    $success_message = '';
}

if (isset($_SESSION['package_selected']) && $_SESSION['package_selected']) {
    $package_message = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                           You have successfully selected a package!
                           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                         </div>';
    unset($_SESSION['package_selected']);
} else {
    $package_message = '';
}

if (isset($_POST['logout'])) {
    session_destroy(); 
    header("Location: login_form.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driving School Dashboard</title>

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
            display: flex;
            align-items: center;
        }

        .card-body img {
            width: 100px;
            height: auto;
            margin-right: 20px;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
        <h4 class="text-center">Driving School</h4>
        <a href="packages.php">Select Package</a>
        <a href="addcars.php">Choose a Car</a>
        <a href="feedback.php">Feedback</a>
        <a href="update_profile.php">Update Profile</a>
        <a href="process_slot_selection.php">Select Slot</a>
        <a href="view_assigned_instructor.php">View Assigned Instructor</a>
        <a href="paymentrazor.php">Make a Payment</a>
        <a href="location10.php">Live location</a>


        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <div class="dashboard-header">
        <h2>Welcome, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Learner'; ?>!</h2>
            <!-- Displayed Messages -->
            <?php echo $success_message; ?>
            <?php echo $package_message; ?>
        </div>

        <div class="row">
            <!-- Image on the left side -->
            <div class="image-section">
                <img src="https://img.freepik.com/free-vector/one-happy-girl-white-background_1308-70173.jpg?t=st=1726410927~exp=1726414527~hmac=de5af2baebd4f0eac79248cd7578408e2a5e28e3d6d1fcc99611ea474410c59d" alt="Learner Image">
            </div>

            <!-- Cards on the right side -->
            <div class="cards-section">
                <!-- Attendance Card -->
                <div class="card">
                    <div class="card-header">
                        Attendance
                    </div>
                    <div class="card-body">
                        19/20 lessons completed. Keep up the good work!
                    </div>
                </div>

                <!-- Homework Progress (Adapted to Driving Lessons) -->
                <div class="card">
                    <div class="card-header">
                        Driving Lesson Progress
                    </div>
                    <div class="card-body">
                        53/56 lessons completed. You're almost there!
                    </div>
                </div>

                <!-- Other Driving School Metrics -->
                <div class="card">
                    <div class="card-header">
                        Upcoming Tests
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Road Safety Test: 28th September, 2024</li>
                            <li>Driving Test: 10th October, 2024</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-L0tfVL2/T3LQ7y9oDKF5s/zhoPe6MGtohHwUrBcBzL4NprJh95S9IxWWJ2jt/aXr" crossorigin="anonymous"></script>
</body>
</html>
