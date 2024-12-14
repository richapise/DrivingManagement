<?php
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php?redirect=packages.php");
    exit();
}

include "db.php";

$message = '';

// Check if the user has already selected a package
$user_id = $_SESSION['user_id'];
$check_query = "SELECT * FROM user_package_selections WHERE user_id = '$user_id'";
$check_result = $conn->query($check_query);

if ($check_result->num_rows > 0) {
    // User has already selected a package
    $message = '<div class="alert alert-warning" role="alert">
                    You have already selected a package. You cannot select another one.
                </div>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['package_id']) && $check_result->num_rows == 0) {
    $package_id = $_POST['package_id'];

    // Insert package selection into database
    $insert_query = "INSERT INTO user_package_selections (user_id, package_id) VALUES ('$user_id', '$package_id')";
    if ($conn->query($insert_query) === TRUE) {
        // Set message for success
        $message = '<div class="alert alert-success" role="alert">
                        Package selected successfully!
                    </div>';
    } else {
        $message = '<div class="alert alert-danger" role="alert">
                        Error selecting package. Please try again.
                    </div>';
    }
}

$query = "SELECT * FROM packages";
$result = $conn->query($query);

if ($result === false) {
    die("Error: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driving School Packages</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            background-image: url("https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.behance.net%2Fgallery%2F53125401%2FDriving-School-Explainer-Video&psig=AOvVaw14YMwzuV7MQOnRzXX1pWnl&ust=1726221231819000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCKiQ0a2RvYgDFQAAAAAdAAAAABAk");
            background-size: cover;
            background-position: center;
            min-height: 100vh;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            color: #333;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .card-text {
            color: #555;
        }

        .btn-primary {
            background-color: #ff5a5f;
            border: none;
            color: #fff;
            transition: background-color 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #e14d52;
        }

        .btn-primary:disabled {
            background-color: #ff5a5f;
            opacity: 0.6; /* Slightly transparent when disabled */
        }

        .alert {
            margin-top: 20px;
        }
        .btn-back {
            background-color: #ff5a5f; /* Set button color to pink */
            color: white;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1 class="text-center mb-4">Available Packages</h1>
        
        <!-- Display the message or alert -->
        <?php echo $message; ?>
        
        <div class="row">
            <?php while ($package = $result->fetch_assoc()) { ?>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $package['package_name']; ?></h5>
                            <p class="card-text"><?php echo $package['package_description']; ?></p>
                            <p class="card-text"><strong>Duration:</strong> <?php echo $package['package_duration']; ?></p>
                            <p class="card-text"><strong>Price:</strong> ₹<?php echo $package['package_price']; ?></p>
                            <form method="post">
                                <input type="hidden" name="package_id" value="<?php echo $package['id']; ?>">
                                <button type="submit" class="btn btn-primary" <?php if ($check_result->num_rows > 0) echo 'disabled'; ?>>Select</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="button-container">
        <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>  
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
