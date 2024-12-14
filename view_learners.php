<?php
// Include database connection
include "db.php";

// Fetch user data from the database
$query = "SELECT id, username FROM user_table"; // Adjust the table name according to your database structure
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Learners</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: white; /* Set a solid background color */
            margin: 0;
            padding: 0;
        }
        .main-content {
            display: flex; /* Flexbox to align image and container side by side */
            align-items: flex-start;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin-left: 20px; /* Gap between image and container */
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #d5006d; /* Set custom button color */
            color: #ffffff; /* Button text color */
        }
        .btn-custom:hover {
            background-color: #a30045; /* Darker shade on hover */
            color: #ffffff; /* Button text color on hover */
        }
        .side-image {
            max-width: 300px; /* Set a max width for the image */
            height: auto;
        }
        .btn-back {
            background-color: #d5006d; /* Set button color to pink */
            color: white;
            margin-top: 20px;
        }
        .btn-back:hover {
            background-color: #ff1493; /* Darker pink on hover */
        }
        .button-container {
            display: flex;
            justify-content: center; /* Center the button */
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <img src="https://img.freepik.com/free-vector/cute-happy-smiling-child-isolated-white-background_1308-69197.jpg?t=st=1728138661~exp=1728142261~hmac=60884fd56e283e37d6512ccac7d9687c47de02bc63d3df40f3331ab1ccc8dd8e&w=360" alt="Side Image" class="side-image">
        <div class="container">
            <h1>View Learners</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Action</th> <!-- Add Action column for buttons -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['id'] . '</td>';
                            echo '<td>' . $row['username'] . '</td>';
                            echo '<td><a href="assign_learner.php?user_id=' . $row['id'] . '" class="btn btn-custom">Choose</a></td>'; // Use custom button class
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="3">No learners found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Centered Back to Dashboard Button -->
    <div class="button-container">
        <a href="admin_dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>
    
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
