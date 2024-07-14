<?php
include 'header.php';
$user_id = $_SESSION['user_id'];
?>
<div class="message-flex-container">
        <div class="left-controls">
            <?php include 'left_controls.php'; ?>
        </div>
        <div class="message-content">
<?php
// Check if a specific message ID is provided in the URL
if(isset($_GET['id'])) {
    $message_id = $_GET['id'];

    // Retrieve the original message
    $sql_message = "SELECT * FROM messages WHERE id = ?";
    $stmt_message = $conn->prepare($sql_message);
    $stmt_message->bind_param("i", $message_id);
    $stmt_message->execute();
    $result_message = $stmt_message->get_result();

    // Check if the original message exists
    if ($result_message->num_rows > 0) {
        // Display the original message
        $row_message = $result_message->fetch_assoc();
        echo "<div class='message-container'>";
        echo "<div class='message-avatar'>";
        echo "<img src='" . GetUserAvatar($conn, $row_message['sender_id']) . "' alt='Avatar'>";
        echo "</div>";
        echo "<div class='message-body'>";
        echo "<p class='message-sender'>" . GetUsername($conn, $row_message['sender_id']) . "</p>";
        echo "<p><strong>Subject:</strong> " . $row_message['subject'] . "</p>";
        echo "<p><strong>Message:</strong> " . $row_message['body'] . "</p>";
        echo "<p class='message-date'><strong>Date:</strong> " . $row_message['date'] . "</p>";
        echo "</div>";
        echo "</div>";

        // Retrieve and display replies to the original message
        $sql_replies = "SELECT * FROM replies WHERE message_id = ?";
        $stmt_replies = $conn->prepare($sql_replies);
        $stmt_replies->bind_param("i", $message_id);
        $stmt_replies->execute();
        $result_replies = $stmt_replies->get_result();

        // Check if there are any replies
        if ($result_replies->num_rows > 0) {
            // Display each reply
            while ($row_reply = $result_replies->fetch_assoc()) {
                echo "<div class='message-container'>";
                echo "<div class='message-avatar'>";
                echo "<img src='" . GetUserAvatar($conn, $row_reply['user_id']) . "' alt='Avatar'>";
                echo "</div>";
                echo "<div class='message-body'>";
                echo "<p class='message-sender'>" . GetUsername($conn, $row_reply['user_id']) . "</p>";
                echo "<p><strong>Reply:</strong> " . $row_reply['reply_body'] . "</p>";
                echo "<p class='message-date'><strong>Date:</strong> " . $row_reply['date'] . "</p>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "No replies found.";
        }
    } else {
        echo "Message not found.";
    }

    $stmt_message->close();
    $stmt_replies->close();
} else {
    echo "Message ID not provided.";
}
?>
</div>
    </div>
<?php
include 'footer.php';
?>