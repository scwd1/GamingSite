<?php include 'header.php'; ?>
<form action="send_message.php" method="post">
    <input type="text" name="recipient" placeholder="Recipient ID"><br>
    <input type="text" name="subject" placeholder="Subject"><br>
    <textarea name="body" placeholder="Message"></textarea><br>
    <input type="submit" value="Send Message">
</form>
<?php include 'footer.php'; ?>