<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: #1a73e8;
            padding: 20px;
        }

        .sidebar h4 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            color: white;
            font-weight: 500;
            text-decoration: none;
            display: block;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            font-size: 16px;
        }

        .sidebar a:hover {
            background-color: #135ab2;
        }

        /* Main content */
        .content {
            margin-left: 270px;
            padding: 20px;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
        }

        .dashboard-header h2 {
            margin: 0;
            color: #1a73e8;
        }

        /* Cards */
        .card {
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: none;
        }

        .card-header {
            background-color: #1a73e8;
            color: white;
            padding: 15px;
            border-radius: 12px 12px 0 0;
            font-weight: bold;
        }

        .card-body {
            padding: 20px;
            background-color: #fff;
        }

        /* Image section */
        .image-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .image-section img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
        }

        /* Layout */
        .row {
            display: flex;
            gap: 20px;
        }

        /* Additional card section */
        .cards-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* General button styling */
        .btn-logout {
            background-color: #1a73e8;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-logout:hover {
            background-color: #135ab2;
        }

        /* Media Queries */
        @media (max-width: 768px) {
            .row {
                flex-direction: column;
            }

            .content {
                margin-left: 0;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .sidebar a {
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h4>Admin Dashboard</h4>
        <a href="learner_info.php">Manage Learner</a>
        <a href="manage_slots.php">Manage Slot</a>
        <a href="assigning_instructor.php">Assigning Instructor</a>
        <a href="view_feedback.php">View Feedback</a>
        <a href="update.php">Update Password</a>
        <a href="location.php">Track Location</a>


        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <div class="dashboard-header">
            <h2>Welcome Admin!</h2>
        </div>

        <div class="row">
            <!-- Image on the left side -->
            <div class="col-md-4 image-section">
                <img
                    src="https://img.freepik.com/free-vector/man-using-laptop-cartoon_1308-120757.jpg?ga=GA1.1.114055217.1709874952"
                    alt="Admin Image">
            </div>

            <!-- Cards on the right side -->
            <div class="col-md-8 cards-section">
                <!-- Manage Learner -->
                <div class="card">
                    <div class="card-header">Manage Learner</div>
                    <div class="card-body">
                        View and manage learner information and progress.
                    </div>
                </div>

                <!-- Manage Slot -->
                <div class="card">
                    <div class="card-header">Manage Slot</div>
                    <div class="card-body">
                        Manage available lesson slots for learners.
                    </div>
                </div>

                <!-- Assigning Instructor -->
                <div class="card">
                    <div class="card-header">Assigning Instructor</div>
                    <div class="card-body">
                        Assign instructors to learners based on their preferences.
                    </div>
                </div>

                <!-- View Feedback -->
                <div class="card">
                    <div class="card-header">View Feedback</div>
                    <div class="card-body">
                        View feedback from learners about their experience.
                    </div>
                </div>

                <!-- Update Password -->
                <div class="card">
                    <div class="card-header">Update Password</div>
                    <div class="card-body">
                        Update your account password for security.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
