<?php
session_start();
include "db.php";

if (isset($_POST['register'])) {
    if (isset($_POST['role'])) {
        $role = $_POST['role'];
        $allowed_roles = array("learner", "instructor");

        if (in_array($role, $allowed_roles)) {
            $username = $_POST['username'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm-password'];

            // Validate password
            if ($password !== $confirm_password) {
                echo "Passwords do not match.";
                exit();
            }

            if (!preg_match('/^(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,}$/', $password)) {
                echo "Password must be at least 8 characters long, contain at least one special character and one number.";
                exit();
            }

            if ($role == 'instructor') {
                // Insert data into the instructor table
                $sql = "INSERT INTO instructors (username, firstname, lastname, email, phone, password) VALUES (?, ?, ?, ?, ?, ?)";
            } else {
                // Insert data into the user_table for learners
                $sql = "INSERT INTO user_table (username, firstname, lastname, email, phone, password) VALUES (?, ?, ?, ?, ?, ?)";
            }

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $username, $firstname, $lastname, $email, $phone, $password);
            if ($stmt->execute()) {
                $_SESSION['registration_success'] = true;
                header("Location: login_form.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Registration is only allowed for learners and instructors.";
        }
    } else {
        echo "Role is not set";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Driving School Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: white;
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
            align-items: center;
            height: calc(100vh - 80px);
            background-color: white;
            padding: 140px;
            margin-top: 80px; /* Added margin to move the form below the nav bar */
        }

        .image-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-container img {
            max-width: 70%;
            height: 500px;
            border-radius: 10px;
        }

        .register-box {
            flex: 1;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            max-width: 500px;
            width: 160%;
            text-align: center;
            margin-top: 120px;
        }

        .register-box h2 {
            color: #ff5a5f;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .register-box input, 
        .register-box select {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .register-box button {
            width: 100%;
            padding: 12px;
            background-color: #ff5a5f;
            border: none;
            color: #fff;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
        }

        .register-box button:hover {
            background-color: #e24e51;
        }

        .register-box .login-link {
            display: block;
            margin-top: 20px;
        }

        .register-box .login-link a {
            color: #ff5a5f;
            text-decoration: none;
            font-weight: bold;
        }

        .register-box .login-link a:hover {
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
        <!-- Image on the left -->
        <div class="image-container">
            <img src="https://img.freepik.com/free-vector/cute-happy-smiling-child-isolated-white_1308-33118.jpg?ga=GA1.1.114055217.1709874952&semt=ais_hybrid" alt="Smiling Child Image">
        </div>

        <!-- Register box on the right -->
        <div class="register-box">
            <h2>Register</h2>
            <form action="register_form.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="text" name="firstname" placeholder="Firstname" required>
                <input type="text" name="lastname" placeholder="Lastname" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone" placeholder="Phone No" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm-password" placeholder="Confirm Password" required>
                <select name="role" required>
                    <option value="" disabled selected>Select your Role</option>
                    <option value="learner">Learner</option>
                    <option value="instructor">Instructor</option>
                </select>
                <button type="submit" name="register">Register</button>
            </form>
            <div class="login-link">
                <p>Already have an account? <a href="login_form.php">Login Here</a></p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
