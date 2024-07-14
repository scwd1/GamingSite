<?php
// Include database connection
include_once 'db.php';

// Function to add achievement to the database
function addAchievement($conn, $title, $description, $type, $tier, $points, $visible, $admin) {
    // SQL query to insert achievement into database
    $sql = "INSERT INTO achievements (title, description, type, tier, points, visible, admin)
            VALUES ('$title', '$description', '$type', $tier, $points, $visible, $admin)";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        return true; // Achievement added successfully
    } else {
        return false; // Error adding achievement
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $tier = $_POST['tier'];
    $points = $_POST['points'];
    $visible = isset($_POST['visible']) ? 1 : 0; // Check if checkbox is checked
    $admin = isset($_POST['admin']) ? 1 : 0; // Check if checkbox is checked

    // Add achievement to database
    if (addAchievement($conn, $title, $description, $type, $tier, $points, $visible, $admin)) {
        echo "Achievement added successfully!";
    } else {
        echo "Error adding achievement.";
    }
}
?>