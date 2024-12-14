<?php
// display_locations.php
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

// Query to fetch all locations
$sql = "SELECT latitude, longitude, timestamp FROM locations ORDER BY timestamp DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Display</title>
</head>
<body>
<h2>Stored Locations</h2>
<table border="1">
    <tr>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>Timestamp</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["latitude"] . "</td><td>" . $row["longitude"] . "</td><td>" . $row["timestamp"] . "</td></tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No locations found.</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
