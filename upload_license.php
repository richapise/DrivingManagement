<?php

session_start();
include "db.php";

function validate_license_no($license_no) {
    // Regular expression for Indian driving license number (e.g., MH39 20220002359)
    $pattern = '/^[A-Z]{2}\d{2} \d{11}$/';

    return preg_match($pattern, $license_no);
}

if (isset($_POST['submit_license'])) {
    // Get and trim the license number from the form
    $license_no = trim($_POST['license_no']);

    // Debugging output
    echo "License number being validated: '" . htmlspecialchars($license_no) . "'<br>";

    // Validate the license number
    if (!validate_license_no($license_no)) {
        $_SESSION['error'] = "Invalid license number format.";
        header("Location: upload_license.php");
        exit();
    }

    // Handle file upload
    if (isset($_FILES['license']) && $_FILES['license']['error'] == 0) {
        $file_tmp = $_FILES['license']['tmp_name'];
        $file_name = basename($_FILES['license']['name']);
        $upload_dir = 'uploads/'; // Directory to store uploaded files
        $upload_file = $upload_dir . $file_name;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($file_tmp, $upload_file)) {
            // Prepare and execute the SQL statement
            $sql = "INSERT INTO instructor_licenses (license_no, file_path) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("ss", $license_no, $upload_file);
                if ($stmt->execute()) {
                    $_SESSION['success'] = "License uploaded successfully!";
                } else {
                    $_SESSION['error'] = "Error executing query: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $_SESSION['error'] = "Error preparing query: " . $conn->error;
            }
        } else {
            $_SESSION['error'] = "Error moving uploaded file.";
        }
    } else {
        $_SESSION['error'] = "Error uploading file.";
    }

    $conn->close();
    header("Location: upload_license.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload License</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
        }

        /* Navigation bar in one line aligned to the right */
        .navbar {
            background-color: white;
           
            padding: 10px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .navbar a {
            margin-left: 20px; /* Space between the hyperlinks */
            text-decoration: none;
            color: black;
            font-weight: bold;
        }

        .navbar a:hover {
            color: #007bff;
        }

        .container {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            width: 100%;
            padding: 30px;
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .form-section {
            flex: 1;
        }

        h3 {
            text-align: center;
            color: #333;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: 700;
            color: #555;
            margin-bottom: 5px;
        }

        input[type="text"], 
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            background-color: #fff;
            color: #333;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background-color: #6f42c1;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #e64949;
        }

        .btn-secondary {
            background-color: #6f42c1;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            display: block;
            width: fit-content;
           
            margin-top: 20px;
            cursor: pointer;
            font-weight: 700;
            text-decoration: none;
        }

        .image-section {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-section img {
            max-width: 300px;
            border-radius: 20px;
        }

    </style>
</head>
<body>

    <!-- Navigation bar with hyperlinks aligned to the right -->
    <div class="navbar">
        <a href="home.php">Home</a>
        <a href="login.php">Login</a>
        <a href="instructor_dashboard.php">Go to Dashboard</a>
        <a href="feedback.php">Feedback</a>
    </div>

    <!-- Content Section -->
    <div class="container">
        <div class="image-section">
            <img src="https://img.freepik.com/premium-vector/hand-holding-driver-license-icon-flat-style-id-card-vector-illustration-isolated-background-person-document-sign-business-concept_157943-41128.jpg?ga=GA1.1.114055217.1709874952&semt=ais_hybrid" alt="Upload License Image">
        </div>

        <div class="form-section">
            <h3>Upload Instructor License</h3>

            <!-- Display success or error messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>

            <form action="upload_license.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="license_no">License Number:</label>
                    <input type="text" id="license_no" name="license_no" required>
                </div>
                <div class="form-group">
                    <label for="license">Select License File:</label>
                    <input type="file" id="license" name="license" accept=".pdf,.jpg,.jpeg,.png" required>
                </div>
                <button type="submit" name="submit_license" class="btn btn-primary">Upload License</button>
            </form>
        </div>
    </div>

    <!-- Back Button Outside the Container -->
    <div class="container">
        <a href="instructor_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>

</body>
</html>
