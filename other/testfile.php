<?php
include 'header.php';
$user_id = $_SESSION['user_id'];
?>
<div class="message-flex-container">
    <div class="left-controls">
        <?php include 'left_controls.php'; ?>
    </div>
    <div class="message-content">
    </div>
</div>
<?php
include 'footer.php';
?>