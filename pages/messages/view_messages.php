<?php
include 'header.php';
$user_id = $_SESSION['user_id'];

if (!IsLoggedIn($conn, $user_id)) {
    header("Location: login.php");
    exit();
}
?>
<div class="message-flex-container">
    <div class="left-controls" id="left-controls">
        <?php require 'left_controls.php'; ?>
    </div>
    <div class="message-content" id="message-content">
        <?php
        // Retrieve messages for the user
        $sql = "SELECT * FROM messages WHERE recipient_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check for errors
        if (!$result) {
            echo "Error: " . $conn->error;
        } else {
            // Display messages
            echo "<h2>Messages</h2>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='message-container'>";
                echo "<p><a href='view_message.php?id=" . $row['id'] . "'><strong>Subject:</strong> " . $row['subject'] . "</a></p>";
                echo "<p style='text-align: right;'><strong>From:</strong> " . GetUserName($conn, $row['sender_id']) . "</p>";
                echo "</div>"; // End of message-container
                echo "<hr>";
            }
        }
        ?>
    </div>
</div>
<?php
include 'footer.php';
?>