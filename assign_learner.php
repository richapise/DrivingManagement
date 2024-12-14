<?php
// Include database connection
include "db.php";

// Check if user_id is provided in the URL
if (isset($_GET['user_id'])) {
    // Get the user_id from the URL
    $user_id = $_GET['user_id'];

    // Assuming you have an instructor ID, you can set it here
    $instructor_id = 1; // Replace 1 with the actual instructor ID

    // Insert the user_id and instructor_id into the user_instructor table
    $query = "INSERT INTO user_instructor (user_id, instructor_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);

    // Bind parameters and execute the query
    $stmt->bind_param("ii", $user_id, $instructor_id);
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        echo "Instructor assigned successfully.";
    } else {
        echo "Failed to assign instructor.";
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo "Learner ID or Instructor ID not provided.";
}

// Close the database connection
$conn->close();
?>
