<?php
// Include database connection
include "db.php";
session_start();

// Initialize variables for messages
$message = "";
$slot_id = "";
$selected_date = "";
$selected_time = "";

// Check if slot_id is provided
if (isset($_GET['slot_id'])) {
    $slot_id = $_GET['slot_id'];

    // Fetch existing slot details
    $query = "SELECT * FROM slots WHERE slot_id = ?";
    $stmt = $conn->prepare($query);

    // Check if statement preparation was successful
    if ($stmt) {
        $stmt->bind_param("i", $slot_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $slot = $result->fetch_assoc();
            $selected_date = $slot['date'];
            $selected_time = $slot['time'];
        } else {
            $message = "Slot not found.";
        }
        $stmt->close();
    } else {
        $message = "Error preparing SQL statement: " . $conn->error;
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Update slot details
    $query = "UPDATE slots SET date = ?, time = ? WHERE slot_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("ssi", $date, $time, $slot_id);

        if ($stmt->execute()) {
            $message = "Slot updated successfully.";
        } else {
            $message = "Failed to update slot. Error: " . $conn->error;
        }
        $stmt->close();
    } else {
        $message = "Error preparing SQL statement: " . $conn->error;
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
    <title>Update Slot</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
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
            max-width: 900px;
            margin: auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        select, input[type="date"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn {
            background-color: #ff5a5f;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .btn-back {
            background-color: #ff5a5f;
            border: none;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="text-center">Update Slot</h1>
                <form action="update_slot.php?slot_id=<?php echo htmlspecialchars($slot_id); ?>" method="POST">
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($selected_date); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="time">Time:</label>
                        <select id="time" name="time" required>
                            <option value="">Select a time</option>
                            <option value="09:00-10:00" <?php echo ($selected_time == "09:00-10:00") ? 'selected' : ''; ?>>9:00 AM - 10:00 AM</option>
                            <option value="10:00-11:00" <?php echo ($selected_time == "10:00-11:00") ? 'selected' : ''; ?>>10:00 AM - 11:00 AM</option>
                            <option value="11:00-12:00" <?php echo ($selected_time == "11:00-12:00") ? 'selected' : ''; ?>>11:00 AM - 12:00 PM</option>
                            <option value="12:00-13:00" <?php echo ($selected_time == "12:00-13:00") ? 'selected' : ''; ?>>12:00 PM - 1:00 PM</option>
                            <option value="13:00-14:00" <?php echo ($selected_time == "13:00-14:00") ? 'selected' : ''; ?>>1:00 PM - 2:00 PM</option>
                            <option value="14:00-15:00" <?php echo ($selected_time == "14:00-15:00") ? 'selected' : ''; ?>>2:00 PM - 3:00 PM</option>
                            <option value="15:00-16:00" <?php echo ($selected_time == "15:00-16:00") ? 'selected' : ''; ?>>3:00 PM - 4:00 PM</option>
                            <option value="16:00-17:00" <?php echo ($selected_time == "16:00-17:00") ? 'selected' : ''; ?>>4:00 PM - 5:00 PM</option>
                            <option value="17:00-18:00" <?php echo ($selected_time == "17:00-18:00") ? 'selected' : ''; ?>>5:00 PM - 6:00 PM</option>
                            <option value="18:00-19:00" <?php echo ($selected_time == "18:00-19:00") ? 'selected' : ''; ?>>6:00 PM - 7:00 PM</option>
                            <option value="19:00-20:00" <?php echo ($selected_time == "19:00-20:00") ? 'selected' : ''; ?>>7:00 PM - 8:00 PM</option>
                            <option value="20:00-21:00" <?php echo ($selected_time == "20:00-21:00") ? 'selected' : ''; ?>>8:00 PM - 9:00 PM</option>
                        </select>
                    </div>
                    <button type="submit" class="btn">Update</button>
                    <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
                </form>

                <!-- Display message -->
                <?php if (!empty($message)): ?>
                    <div class="message alert <?php echo strpos($message, 'Failed') !== false ? 'alert-danger' : 'alert-success'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Image Section -->
            <div class="col-md-6">
                <img src="https://img.freepik.com/free-vector/man-holding-clock-time-management-concept_23-2148823171.jpg?t=st=1726413296~exp=1726416896~hmac=c1c2f79c77b7a3865595b718ffdd80ca09be33c8ad4429bbfa191fb87c4a2551&w=740" alt="Update Slot Illustration" class="img-fluid rounded">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var dateInput = document.getElementById('date');
            var timeSelect = document.getElementById('time');
            var today = new Date().toISOString().split('T')[0]; // Get today's date in 'YYYY-MM-DD' format
            dateInput.min = today;

            dateInput.addEventListener('change', function () {
                var selectedDate = new Date(dateInput.value);
                var currentDate = new Date();
                
                // Disable past time slots if the selected date is today
                if (selectedDate.toDateString() === currentDate.toDateString()) {
                    var currentHour = currentDate.getHours();

                    for (var i = 0; i < timeSelect.options.length; i++) {
                        var optionValue = timeSelect.options[i].value;
                        var optionHour = parseInt(optionValue.split(':')[0]);

                        if (optionHour <= currentHour) {
                            timeSelect.options[i].disabled = true;
                        } else {
                            timeSelect.options[i].disabled = false;
                        }
                    }
                } else {
                    // Enable all options if a future date is selected
                    for (var i = 0; i < timeSelect.options.length; i++) {
                        timeSelect.options[i].disabled = false;
                    }
                }
            });
        });
    </script>
</body>
</html>
