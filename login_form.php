<?php
session_start();
include "db.php";

if (isset($_SESSION['registration_success']) && $_SESSION['registration_success'] == true) {
    echo "Registration successful! Please login.";
    unset($_SESSION['registration_success']);
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check admin login
    $query = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Error preparing SQL statement: " . $conn->error);
    }
    $stmt->bind_param("ss", $username, $password);
    if (!$stmt->execute()) {
        die("Error executing SQL statement: " . $stmt->error);
    }
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $admin_data = $result->fetch_assoc();
        $_SESSION['user_id'] = $admin_data['admin_id'];
        $_SESSION['username'] = $admin_data['username'];
        $_SESSION['user_role'] = 'admin';
        header("Location: admin_dashboard.php");
        exit();
    }

    // Check learner login
    $query = "SELECT * FROM user_table WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Error preparing SQL statement: " . $conn->error);
    }
    $stmt->bind_param("ss", $username, $password);
    if (!$stmt->execute()) {
        die("Error executing SQL statement: " . $stmt->error);
    }
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $learner_data = $result->fetch_assoc();
        $_SESSION['user_id'] = $learner_data['id'];
        $_SESSION['username'] = $learner_data['username'];
        $_SESSION['user_role'] = 'learner';
        header("Location: dashboard.php");
        exit();
    }

    // Check instructor login
    $query = "SELECT * FROM instructors WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Error preparing SQL statement: " . $conn->error);
    }
    $stmt->bind_param("ss", $username, $password);
    if (!$stmt->execute()) {
        die("Error executing SQL statement: " . $stmt->error);
    }
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $instructor_data = $result->fetch_assoc();
        $_SESSION['user_id'] = $instructor_data['id'];
        $_SESSION['username'] = $instructor_data['username'];
        $_SESSION['user_role'] = 'instructor';
        header("Location: instructor_dashboard.php");
        exit();
    } else {
        echo "Invalid username or password";
    }

    // Invalid credentials
    header("Location: login_form.php?error=invalid");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Driving School Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .top-nav {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px 40px;
        }

        .top-nav .navbar-brand {
            font-weight: bold;
        }

        .top-nav .nav-link {
            color: #333;
            font-weight: bold;
            margin-left: 20px;
        }

        .top-nav .nav-links {
            display: flex;
            align-items: center;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            height: calc(100vh - 80px);
            background-color: #f2f2f2;
            padding: 40px 20px;
        }

        .box-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 20px;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 10px;
            margin-right: 40px;
        }

        .box {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden; /* Ensure images fit within the box */
        }
        /* Add this to your existing styles */

/* Ensure smooth transitions */
.box img {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Hover effect to scale and add shadow */
.box:hover img {
    transform: scale(1.05); /* Slightly enlarges the image */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Adds a shadow effect */
}

/* Optional: Add a slight rotate effect */
.box:hover img {
    transform: scale(1.05) rotate(2deg); /* Adds a slight rotation */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}


        .box img {
            width: 100%;
            height: auto;
            display: block;
        }

        .login-box {
            background-color: #fff;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            max-width: 400px;
            width: 160%;
            text-align: center;
        }

        .login-box h2 {
            color: #ff5a5f;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .login-box input {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .login-box button {
            width: 100%;
            padding: 15px;
            background-color: #ff5a5f;
            border: none;
            color: #fff;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
        }

        .login-box button:hover {
            background-color: #e24e51;
        }

        .login-box .register-link {
            display: block;
            margin-top: 20px;
        }

        .login-box .register-link a {
            color: #ff5a5f;
            text-decoration: none;
            font-weight: bold;
        }

        .login-box .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="top-nav d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="Home.php">Driving School</a>
        <div class="nav-links">
            <a href="Home.php" class="nav-link">Home</a>
            <a href="login_form.php" class="nav-link">Login</a>
            <a href="register_form.php" class="nav-link">Register</a>
            <a href="feedback.php" class="nav-link">Feedback</a>
        </div>
    </div>

    <div class="container">
        <div class="box-container">
            <div class="box">
                <a href="register_form.php">
                    <img src="https://static.vecteezy.com/system/resources/previews/015/618/036/original/driving-school-with-education-process-of-car-training-and-learning-to-drive-to-get-drivers-license-in-flat-cartoon-hand-drawn-templates-illustration-vector.jpg" alt="Login Illustration">
                </a>
            </div>
            <div class="box">
                <a href="register_form.php">
                    <img src="https://static.vecteezy.com/system/resources/previews/015/618/058/non_2x/driving-school-with-education-process-of-car-training-and-learning-to-drive-to-get-drivers-license-in-flat-cartoon-hand-drawn-templates-illustration-vector.jpg" alt="Driving Illustration">
                </a>
            </div>
            <div class="box">
                <a href="register_form.php">
                    <img src="https://static.vecteezy.com/system/resources/previews/015/618/046/non_2x/driving-school-with-education-process-of-car-training-and-learning-to-drive-to-get-drivers-license-in-flat-cartoon-hand-drawn-templates-illustration-vector.jpg" alt="Driving Car">
                </a>
            </div>
            <div class="box">
                <a href="register_form.php">
                    <img src="https://static.vecteezy.com/system/resources/previews/015/618/053/non_2x/driving-school-with-education-process-of-car-training-and-learning-to-drive-to-get-drivers-license-in-flat-cartoon-hand-drawn-templates-illustration-vector.jpg" alt="Driver License">
                </a>
            </div>
        </div>

        <div class="login-box">
            <h2>Login</h2>
            <form action="" method="post">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="login">Login</button>
        </form>

            <div class="register-link">
                <p>Don't have an account? <a href="register_form.php">Register Here</a></p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
