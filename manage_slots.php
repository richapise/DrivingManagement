<?php
session_start();
include 'db.php'; // Assuming this file contains your database connection

// Add Slot
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_slot'])) {
    $userId = $conn->real_escape_string($_POST['user_id']);
    $date = $conn->real_escape_string($_POST['date']);
    $time = $conn->real_escape_string($_POST['time']);

    $sql = "INSERT INTO slots (user_id, date, time) VALUES ('$userId', '$date', '$time')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Slot added successfully";
    } else {
        $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Edit Slot
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_slot'])) {
    $slotId = $conn->real_escape_string($_POST['id']);
    $date = $conn->real_escape_string($_POST['date']);
    $time = $conn->real_escape_string($_POST['time']);

    $sql = "UPDATE slots SET date='$date', time='$time' WHERE slot_id='$slotId'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Slot updated successfully";
    } else {
        $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete Slot
if (isset($_GET['delete'])) {
    $slotId = $conn->real_escape_string($_GET['delete']);

    $sql = "DELETE FROM slots WHERE slot_id='$slotId'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Slot deleted successfully";
    } else {
        $_SESSION['error'] = "Error deleting slot: " . $conn->error;
    }
}

// Fetch Slots
$slots = [];
$sql = "SELECT slots.slot_id, slots.date, slots.time, user_table.username FROM slots JOIN user_table ON slots.user_id = user_table.id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $slots[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Slots</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
            
        }
        .btn-custom {
            background-color: #d5006d; /* Custom color */
            color: white; /* Text color */
        }
        .btn-custom:hover {
            background-color: #d5006d; /* Darker shade for hover effect */
            color: white; /* Keep text color white on hover */
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1>Manage Slots</h1>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <button class="btn btn-custom mb-3" data-bs-toggle="modal" data-bs-target="#addSlotModal">Add Slot</button>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($slots as $slot): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($slot['username']); ?></td>
                        <td><?php echo htmlspecialchars($slot['date']); ?></td>
                        <td><?php echo htmlspecialchars($slot['time']); ?></td>
                        <td>
                            <button class="btn btn-custom btn-sm" data-bs-toggle="modal" data-bs-target="#editSlotModal<?php echo $slot['slot_id']; ?>">Edit</button>
                            <a href="manage_slots.php?delete=<?php echo $slot['slot_id']; ?>" class="btn btn-custom btn-sm" onclick="return confirm('Are you sure you want to delete this slot?');">Delete</a>
                        </td>
                    </tr>

                    <!-- Edit Slot Modal -->
                    <div class="modal fade" id="editSlotModal<?php echo $slot['slot_id']; ?>" tabindex="-1" aria-labelledby="editSlotModalLabel<?php echo $slot['slot_id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editSlotModalLabel<?php echo $slot['slot_id']; ?>">Edit Slot</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="manage_slots.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $slot['slot_id']; ?>">
                                        <div class="mb-3">
                                            <label for="username<?php echo $slot['slot_id']; ?>" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username<?php echo $slot['slot_id']; ?>" value="<?php echo htmlspecialchars($slot['username']); ?>" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="date<?php echo $slot['slot_id']; ?>" class="form-label">Date</label>
                                            <input type="date" class="form-control" id="date<?php echo $slot['slot_id']; ?>" name="date" value="<?php echo htmlspecialchars($slot['date']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="time<?php echo $slot['slot_id']; ?>" class="form-label">Time</label>
                                            <select class="form-control" id="time<?php echo $slot['slot_id']; ?>" name="time" required>
                                                <option value="09:00-10:00" <?php if ($slot['time'] == '09:00-10:00') echo 'selected'; ?>>9:00 AM - 10:00 AM</option>
                                                <option value="10:00-11:00" <?php if ($slot['time'] == '10:00-11:00') echo 'selected'; ?>>10:00 AM - 11:00 AM</option>
                                                <option value="11:00-12:00" <?php if ($slot['time'] == '11:00-12:00') echo 'selected'; ?>>11:00 AM - 12:00 PM</option>
                                                <option value="12:00-13:00" <?php if ($slot['time'] == '12:00-13:00') echo 'selected'; ?>>12:00 PM - 1:00 PM</option>
                                                <option value="13:00-14:00" <?php if ($slot['time'] == '13:00-14:00') echo 'selected'; ?>>1:00 PM - 2:00 PM</option>
                                                <option value="14:00-15:00" <?php if ($slot['time'] == '14:00-15:00') echo 'selected'; ?>>2:00 PM - 3:00 PM</option>
                                                <option value="15:00-16:00" <?php if ($slot['time'] == '15:00-16:00') echo 'selected'; ?>>3:00 PM - 4:00 PM</option>
                                                <option value="16:00-17:00" <?php if ($slot['time'] == '16:00-17:00') echo 'selected'; ?>>4:00 PM - 5:00 PM</option>
                                                <option value="17:00-18:00" <?php if ($slot['time'] == '17:00-18:00') echo 'selected'; ?>>5:00 PM - 6:00 PM</option>
                                                <option value="18:00-19:00" <?php if ($slot['time'] == '18:00-19:00') echo 'selected'; ?>>6:00 PM - 7:00 PM</option>
                                            </select>
                                        </div>
                                        <button type="submit" name="edit_slot" class="btn btn-custom">Update Slot</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="admin_dashboard.php" class="btn btn-custom mb-3">Back to Dashboard</a>
    </div>

    <!-- Add Slot Modal -->
    <div class="modal fade" id="addSlotModal" tabindex="-1" aria-labelledby="addSlotModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSlotModalLabel">Add Slot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="manage_slots.php" method="POST">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User ID</label>
                            <input type="number" class="form-control" id="user_id" name="user_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="time" class="form-label">Time</label>
                            <select class="form-control" id="time" name="time" required>
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
                            </select>
                        </div>
                        <button type="submit" name="add_slot" class="btn btn-custom">Add Slot</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
