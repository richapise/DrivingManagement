<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learner Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white; /* Light pink background */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px; /* Limit the width */
            padding: 20px;
        }

        .user-info {
            display: none;
            color: #d81b60; /* Dark pink color for user information */
        }

        .user-info.active {
            display: block;
        }

        .btn-primary {
            background-color: #d81b60; /* Dark pink color for the button */
            border: none; /* Remove default border */
        }

        .btn-primary:hover {
            background-color: #c2185b; /* Darker shade on hover */
        }

        h1 {
            color: #d81b60; /* Dark pink for the header */
        }

        .btn-secondary {
            margin: 30px;
            background-color: #e91e63; /* Secondary button color */
            border: none;
        }

        .btn-secondary:hover {
            background-color: #c2185b; /* Darker shade on hover */
        }

        .left-image {
            max-width: 60%; /* Ensure the image is responsive */
            height: 400px; /* Maintain aspect ratio */
        }

        .list-group-item {
            background-color: #f8e0f5; /* Light pink for list items */
            border: 1px solid #d81b60; /* Dark pink border */
        }

        .list-group-item:hover {
            background-color: #e1bee7; /* Hover effect for list items */
        }

        /* New styles for user information text */
        .user-info p {
            color: #d81b60; /* Dark pink for email, phone, and package */
            margin: 0; /* Remove default margin */
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <img src="https://img.freepik.com/free-vector/boy-girl-with-happy-face_1308-29240.jpg?t=st=1728127868~exp=1728131468~hmac=bfb149c2da0b81907eaed5ff84a7dfb84bef982633bdacbf65706a2a5b4a339a&w=826"
                    alt="Happy Learners" class="left-image">
            </div>
            <div class="col-md-6">
                <h1 class="text-center">Learner Information</h1>

                <ul class="list-group">
                    <?php
                    include "db.php";

                    // Query to fetch user information with their selected package
                    $query = "SELECT u.*, p.package_name 
                              FROM user_table u 
                              LEFT JOIN user_package_selections ups ON u.id = ups.user_id
                              LEFT JOIN packages p ON ups.package_id = p.id";
                    $result = $conn->query($query);

                    if ($result) {
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<li class='list-group-item'>";
                                echo "<div class='d-flex justify-content-between align-items-center'>";
                                echo "<span>" . $row['firstname'] . " " . $row['lastname'] . "</span>";
                                echo "<button class='btn btn-primary' onclick='toggleUserInfo(" . $row['id'] . ")'>View Info</button>";
                                echo "</div>";
                                echo "<div id='user-info-" . $row['id'] . "' class='user-info mt-2'>";
                                echo "<p>Email: " . $row['email'] . "</p>";
                                echo "<p>Phone: " . $row['phone'] . "</p>";
                                echo "<p>Package: " . $row['package_name'] . "</p>";
                                // Add more user information here if needed
                                echo "</div>";
                                echo "</li>";
                            }
                        } else {
                            echo "<li class='list-group-item'>No users found.</li>";
                        }
                    } else {
                        echo "<li class='list-group-item'>Error: " . $conn->error . "</li>";
                    }

                    $conn->close();
                    ?>
                </ul>
                <div class="text-center mb-3">
                    <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div> <!-- End of col-md-6 for learner information -->
        </div> <!-- End of row -->
    </div> <!-- End of container-fluid -->

    <script>
        function toggleUserInfo(userId) {
            var userInfo = document.getElementById('user-info-' + userId);
            userInfo.classList.toggle('active');
        }
    </script>
</body>

</html>
