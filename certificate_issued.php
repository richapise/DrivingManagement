<?php
// Start session
session_start();

// Check if the certificate was issued successfully and the session data exists
if (!isset($_SESSION['certificate_code'])) {
    echo "No certificate data available.";
    exit;
}

// Retrieve data from the session
$certificate_code = $_SESSION['certificate_code'];
$learner_name = $_SESSION['learner_name'];
$package_name = $_SESSION['package_name'];
$package_duration = $_SESSION['package_duration'];
$instructor_name = $_SESSION['instructor_name'];
$issue_date = $_SESSION['issue_date'];

// You can clear the session data if needed
// session_unset();  // This will clear all session data

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Issued</title>
    <!-- Include Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Merriweather', serif;
            background-color: #f4f4f4;
        }
        h1 {
            font-weight: 700; /* Bold for titles */
            font-size: 2.5rem; /* Larger font for the certificate title */
            color: #333;
        }
        p {
            font-size: 1.2rem; /* Slightly larger for readability */
            color: #555;
        }
        .certificate-name {
            font-family: 'Dancing Script', cursive;
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
        }
        .instructor-signature {
            font-family: 'Dancing Script', cursive;
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #CF9FFF;
        }
        .card-body {
            padding: 30px;
        }
        .btn-back {
            background-color:  #6f42c1; /* Set button color to pink */
            color: white;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">Certificate of Completion</h1>
                <hr>
                <p class="text-center">
                    This is to certify that <strong class="certificate-name"><?php echo $learner_name; ?></strong> has successfully completed the 
                    <strong><?php echo $package_name; ?></strong> 
                    (<?php echo $package_duration; ?>) as prescribed by the Department of Motor Vehicles and the curriculum of 
                    <strong>[Driving School Name]</strong> on <strong><?php echo $issue_date; ?></strong>.
                </p>
                <br>
                <p class="text-center">
                    <strong>Issued by: </strong><span class="instructor-signature"><?php echo $instructor_name; ?></span>
                </p>
                <p class="text-center">
                    <strong>Certificate Code: </strong><?php echo $certificate_code; ?>
                </p>
                <br>
                <div class="text-center">
                    <!-- Signature Section -->
                    <p><strong>Signature:</strong></p>
                    <img src="https://www.shutterstock.com/image-vector/fake-autograph-samples-handdrawn-signatures-260nw-2325821623.jpg" alt="Instructor Signature" style="width:200px; height:auto;">
                    <p><strong class="instructor-signature"><?php echo $instructor_name; ?></strong></p>
                </div>
                <div class="button-container">
        <a href="instructor_dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>
            </div>
        </div>
    </div>
</body>
</html>