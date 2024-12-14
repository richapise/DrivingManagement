<?php
session_start();
include "db.php"; // Ensure you have your database connection included

if (isset($_POST['verify'])) {
    // Get entered OTP
    $entered_otp = $_POST['otp'];

    // Get stored OTP from session
    $stored_otp = $_SESSION['otp'];
    $email = $_SESSION['email'];

    // Validate OTP
    if ($entered_otp == $stored_otp) {
        // Update user table to mark email as verified
        $sql = "UPDATE user_table SET email_verified = 1 WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        
        if ($stmt->execute()) {
            $_SESSION['registration_success'] = true;
            header("Location: login_form.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        OTP Verification
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="otp">Enter OTP</label>
                                <input type="text" class="form-control" id="otp" name="otp" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="verify">Verify OTP</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
