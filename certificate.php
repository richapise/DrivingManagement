<?php
// Include database connection
include "db.php";

// Start session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $learner_id = $_POST['learner_id'];
    $learner_name = $_POST['learner_name'];
    $package_id = $_POST['package_id']; // Fetch selected package ID
    $instructor_name = $_POST['instructor_name'];
    
    // Fetch the package details from the database
    $package_query = "SELECT package_name, package_duration FROM packages WHERE id = ?";
    $package_stmt = $conn->prepare($package_query);
    if (!$package_stmt) {
        die("Package query prepare failed: " . $conn->error);  // Error handling
    }

    $package_stmt->bind_param("i", $package_id);
    $package_stmt->execute();
    $package_stmt->bind_result($package_name, $package_duration);
    $package_stmt->fetch();
    $package_stmt->close();

    if ($package_name && $package_duration) {
        // Generate a unique certificate code
        $certificate_code = uniqid("CERT-");

        // Insert certificate record into database
        $query = "INSERT INTO certificates (learner_id, learner_name, certificate_code, issue_date, package_name, package_duration, instructor_name, status) 
                  VALUES (?, ?, ?, NOW(), ?, ?, ?, 'Issued')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isssss", $learner_id, $learner_name, $certificate_code, $package_name, $package_duration, $instructor_name);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Store data in session to pass to certificate_issued.php
            $_SESSION['certificate_code'] = $certificate_code;
            $_SESSION['learner_name'] = $learner_name;
            $_SESSION['package_name'] = $package_name;
            $_SESSION['package_duration'] = $package_duration;
            $_SESSION['instructor_name'] = $instructor_name;
            $_SESSION['issue_date'] = date("Y-m-d");

            // Redirect to the certificate issued page
            header("Location: certificate_issued.php");
            exit;
        } else {
            echo "Failed to issue certificate.";
        }

        // Close the statement and database connection
        $stmt->close();
    } else {
        echo "Invalid package selected.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Certificate</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
        background-color: white;
    }
        .form-container {
            max-width: 500px; /* Set a max width for the form */
            background-color:	#6f42c1;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: white;
        }
        .img-container img {
            max-width: 550px; 
            border-radius: 10px;/* Make image responsive */
          
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        btn-custom-pink {
        background-color: #6f42c1;
        border-color:white;
        color: white;
    }
    .btn-custom-pink:hover {
        background-color:#6f42c1; /* A slightly darker pink for hover effect */
        border-color: #6f42c1;
        color: white;
    }
    .btn-back {
            background-color: #6f42c1; /* Set button color to pink */
            color: white;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <!-- Left side: Image -->
            <div class="col-md-6 img-container">
                <img src="https://img.freepik.com/premium-photo/man-red-car-with-sign-that-says-happy-birthday_1116403-2346.jpg?w=740" alt="Certification Image">
            </div>
            <!-- Right side: Form -->
            <div class="col-md-6">
                <div class="form-container">
                    <h1>Issue Certificate</h1>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3">
                            <label for="learner_id" class="form-label">Learner ID</label>
                            <input type="number" name="learner_id" id="learner_id" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="learner_name" class="form-label">Learner Name</label>
                            <input type="text" name="learner_name" id="learner_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="package_id" class="form-label">Select Package</label>
                            <select name="package_id" id="package_id" class="form-control" required>
                                <?php
                                // Fetch available packages from the database
                                $package_query = "SELECT id, package_name, package_duration FROM packages";
                                $package_result = $conn->query($package_query);
                                while ($row = $package_result->fetch_assoc()) {
                                    echo "<option value=\"" . $row['id'] . "\">" . $row['package_name'] . " (" . $row['package_duration'] . ")</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="instructor_name" class="form-label">Instructor Name</label>
                            <input type="text" name="instructor_name" id="instructor_name" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-custom-pink w-100">Issue Certificate</button>

                    </form>

                </div>
                <div class="button-container">
        <a href="instructor_dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>
            </div>
        </div>
    </div>
</body>
</html>
