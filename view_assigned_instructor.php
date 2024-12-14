<?php
include "db.php"; // Assuming this includes your database connection details and establishes $conn
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT u.firstname AS user_firstname, u.lastname AS user_lastname,
               i.firstname AS instructor_firstname, i.lastname AS instructor_lastname
        FROM user_instructor ui
        LEFT JOIN user_table u ON ui.user_id = u.id
        LEFT JOIN instructors i ON ui.instructor_id = i.id
        WHERE ui.user_id = ?";
        
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
} else {
    die("Error executing statement: " . $stmt->error);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Assigned Instructors</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #ADD8E6;
            padding-top: 20px;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            display: flex;
            align-items: center;
        }
        .image-column {
            flex: 1;
            text-align: center;
            padding-right: 150px;
        }
        .image-column img {
            max-width: 150%;
            height: 450px;
            border-radius: 8px;
        }
        .content-column {
            flex: 2;
        }
        .table {
            margin-top: 20px;
        }
        .btn-custom {
            background-color: #ff5a5f;
            border: none;
            color: white;
        }
        .btn-custom:hover {
            background-color: #e14e4b; /* Slightly darker shade for hover effect */
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="image-column">
            <img src="https://img.freepik.com/free-vector/business-men-shake-hands-congratulate-business-success_1150-35814.jpg?t=st=1726416572~exp=1726420172~hmac=b4aed082cc36683a26235dd10262ee85a623397d1df47afd9abe1708293b6165&w=740" alt="Business Success">
        </div>
        <div class="content-column">
            <h2>Assigned Instructors</h2>
            
            <?php if ($result->num_rows > 0) : ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Instructor Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo $row['user_firstname'] . ' ' . $row['user_lastname']; ?></td>
                                <td><?php echo $row['instructor_firstname'] . ' ' . $row['instructor_lastname']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert alert-info" role="alert">
                    No assigned instructors found.
                </div>
            <?php endif; ?>

            <a href="dashboard.php" class="btn btn-custom">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
