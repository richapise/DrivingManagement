<?php
// track_location.php
$servername = "localhost"; // Change if your server is different
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "registration_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get latitude and longitude from POST request
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO locations (latitude, longitude, timestamp) VALUES (?, ?, NOW())");
$stmt->bind_param("dd", $latitude, $longitude);

// Execute the statement
if ($stmt->execute()) {
    echo "Location updated successfully.";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>
