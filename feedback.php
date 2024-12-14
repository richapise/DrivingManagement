<?php
session_start();
include 'db.php'; // Assuming this file contains your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $feedback = $_POST['feedback'];

    $sql = "INSERT INTO feedback (name, email, feedback) VALUES ('$name', '$email', '$feedback')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['feedback_message'] = "Feedback submitted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Give Us Your Feedback</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #ffffff; /* White background */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px; /* Space between the form and the image */
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 100%;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-weight: 700;
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: 700;
            color: #555;
        }

        textarea,
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-family: inherit;
            background-color: rgba(255, 255, 255, 0.8);
            color: #333;
            font-size: 0.9rem;
        }

        textarea {
            resize: vertical;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: #ff5a5f; /* Pink color */
            color: white;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #ff4044;
        }

        .feedback-message {
            margin-top: 20px;
            color: #28a745;
            font-weight: 700;
            text-align: center;
        }

        .image-container {
            max-width: 300px;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            
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
        <div class="form-container">
            <h3>Driving School Feedback</h3>
            <form action="#" method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="feedback">Feedback:</label>
                    <textarea id="feedback" name="feedback" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Feedback</button>
            </form>
            <div class="button-container">
        <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>
            
            <!-- Display feedback message if set -->
            <?php if(isset($_SESSION['feedback_message'])): ?>
                <div class="feedback-message">
                    <?php echo $_SESSION['feedback_message']; ?>
                </div>
                <?php unset($_SESSION['feedback_message']); ?>
            <?php endif; ?>
        </div>

        <!-- Image section -->
        <div class="image-container">
            <img src="https://img.freepik.com/premium-photo/3d-cartoon-character_1029469-265369.jpg?w=360" alt="Cartoon Character Image">
        </div>
          
    </div>
    
</body>
</html>