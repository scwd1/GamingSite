<?php
session_start();
include 'db.php'; // Include your database connection file

// Retrieve form data
$sender = $_SESSION['user_id'];
$recipient = $_POST['recipient'];
$subject = $_POST['subject'];
$body = $_POST['body'];

// Insert message into database
$sql = "INSERT INTO messages (sender, recipient, subject, body) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $sender, $recipient, $subject, $body);
$stmt->execute();
$stmt->close();
$conn->close();

// Redirect back to previous page
header("Location: view_messages.php");
exit();
?>