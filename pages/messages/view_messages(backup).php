<?php
include 'header.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Retrieve user ID and username from session
$user_id = $_SESSION['user_id'];

// Prepare and execute query to retrieve messages with sender's username
$sql = "SELECT messages.*, users.username AS sender_username FROM messages 
        JOIN users ON messages.sender = users.id
        WHERE recipient = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check for errors
if (!$result) {
    echo "Error: " . $conn->error;
} else {
    // Display messages if there are any
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p><strong>From:</strong> " . $row['sender_username'] . "</p>";
            echo "<p><strong>Subject:</strong> " . $row['subject'] . "</p>";
            echo "<p>" . $row['body'] . "</p>";
            echo "<hr>";
        }
    } else {
        echo "No messages found.";
    }
}

// Close statement and database connection
$stmt->close();
$conn->close();

include 'footer.php';
?>