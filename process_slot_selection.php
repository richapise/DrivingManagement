<?php
// Include database connection
include "db.php";
session_start();

// Initialize variables for messages
$message = "";
$selected_date = "";
$selected_time = "";
$slot_id = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $date = $_POST['date'];
    $time = $_POST['time'];
    $user_id = $_SESSION['user_id'];

    // Check how many slots the user has already booked for the selected date
    $query = "SELECT COUNT(*) AS slot_count FROM slots WHERE user_id = ? AND date = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $user_id, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['slot_count'] >= 2) {
        // User has already booked two slots for the day
        $message = "You have already booked two slots for the selected day. You cannot book more slots.";
    } else {
        // Check if the selected slot is already booked by someone else
        $query = "SELECT * FROM slots WHERE date = ? AND time = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $date, $time);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Slot is already booked
            $message = "The selected slot is already booked. Please choose a different slot.";
        } else {
            // Slot is available, proceed to book it
            $query = "INSERT INTO slots (user_id, date, time) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);

            // Check if the statement was prepared successfully
            if ($stmt) {
                // Bind parameters and execute the statement
                $stmt->bind_param("iss", $user_id, $date, $time);
                if ($stmt->execute()) {
                    // Slot inserted successfully
                    $message = "Slot selected successfully.";
                    $selected_date = $date;
                    $selected_time = $time;

                    // Get the slot ID for updating
                    $slot_id = $conn->insert_id;
                } else {
                    // Failed to execute the statement
                    $message = "Failed to select slot. Error: " . $conn->error;
                }
                // Close the statement
                $stmt->close();
            } else {
                // Error preparing the statement
                $message = "Error preparing SQL statement. Error: " . $conn->error;
            }
        }
    }
    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Slot Selection</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            align-items: center;
        }
        .form-container {
            max-width: 500px;
            margin-right: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        select, input[type="date"] {
            width: 100%;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn {
            background-color: #ff5a5f;
            color: #fff;
            border: none;
            padding: 15px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .image-container {
            flex: 1;
            display: flex;
            justify-content: center;
        }
        img {
            max-width: 100%;
            height: auto;
        }
        .btn-back {
            background-color: #ff5a5f;
            color: white;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1 class="text-center">Select a Slot</h1>
            <form action="process_slot_selection.php" method="POST">
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" required class="form-control" style="height: 50px;" min="">
                </div>
                <div class="form-group">
                    <label for="time">Time:</label>
                    <select id="time" name="time" required>
                        <option value="">Select a time</option>
                        <option value="09:00-10:00">9:00 AM - 10:00 AM</option>
                        <option value="10:00-11:00">10:00 AM - 11:00 AM</option>
                        <option value="11:00-12:00">11:00 AM - 12:00 PM</option>
                        <option value="12:00-13:00">12:00 PM - 1:00 PM</option>
                        <option value="13:00-14:00">1:00 PM - 2:00 PM</option>
                        <option value="14:00-15:00">2:00 PM - 3:00 PM</option>
                        <option value="15:00-16:00">3:00 PM - 4:00 PM</option>
                        <option value="16:00-17:00">4:00 PM - 5:00 PM</option>
                        <option value="17:00-18:00">5:00 PM - 6:00 PM</option>
                        <option value="18:00-19:00">6:00 PM - 7:00 PM</option>
                        <option value="19:00-20:00">7:00 PM - 8:00 PM</option>
                        <option value="20:00-21:00">8:00 PM - 9:00 PM</option>
                    </select>
                </div>
                <button type="submit" class="btn">Submit</button>
            </form>
            <div class="button-container">
                <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
            </div>

            <!-- Display message and selected slot -->
            <?php if (!empty($message)): ?>
                <div class="message alert <?php echo strpos($message, 'Failed') !== false ? 'alert-danger' : 'alert-success'; ?>">
                    <?php echo $message; ?>
                </div>
                <?php if ($selected_date && $selected_time): ?>
                    <div class="message alert alert-info">
                        Selected Date: <?php echo htmlspecialchars($selected_date); ?><br>
                        Selected Time: <?php echo htmlspecialchars($selected_time); ?>
                    </div>
                    <?php if ($slot_id): ?>
                        <a href="update_slot.php?slot_id=<?php echo htmlspecialchars($slot_id); ?>" class="btn">Update Slot</a>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="image-container">
            <img src="https://img.freepik.com/free-vector/sticker-design-with-coach-boy-holding-timer_1308-69958.jpg?t=st=1726413788~exp=1726417388~hmac=bd9135b16d29087031b03e47a1ecd281d989f6bbd82f92a9f2983d5d3c70a466&w=360" alt="Coach with Timer">
        </div>
    </div>

    <script>
        // Set the minimum date to today
        document.getElementById('date').min = new Date().toISOString().split('T')[0];

        // Disable past time options if today is selected
        document.getElementById('date').addEventListener('change', function() {
            var selectedDate = new Date(this.value);
            var today = new Date();
            var timeSelect = document.getElementById('time');
            
            if (selectedDate.toDateString() === today.toDateString()) {
                var currentTime = today.getHours();
                for (var i = 0; i < timeSelect.options.length; i++) {
                    var optionTime = parseInt(timeSelect.options[i].value.split(':')[0]);
                    timeSelect.options[i].disabled = optionTime <= currentTime;
                }
            } else {
                for (var i = 0; i < timeSelect.options.length; i++) {
                    timeSelect.options[i].disabled = false;
                }
            }
        });
    </script>
</body>
</html>
