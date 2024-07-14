<?php
session_start();
include 'db.php';

if (isset($_POST['message_id']) && isset($_POST['reply_body'])) {
    $message_id = $_POST['message_id'];
    $reply_body = $_POST['reply_body'];
    $user_id = $_SESSION['user_id'];
    
    // Insert the reply into the database
    $sql = "INSERT INTO replies (message_id, user_id, reply_body) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $message_id, $user_id, $reply_body);
    $stmt->execute();
    
    // Check if the reply was successfully inserted
    if ($stmt->affected_rows > 0) {
        echo "Reply sent successfully!";
    } else {
        echo "Error sending reply.";
    }
    
    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>