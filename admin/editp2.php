<?php
// Check if file ID is provided in the URL
if(isset($_GET['file'])) {
    $file = $_GET['file'];
    
    // Display the file content in a text editor
    if (file_exists($file)) {
        if (is_writable($file)) {
            // Handle form submission to save changes
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['content']) && isset($_POST['save'])) {
                $newContent = $_POST['content'];
                // Validate and sanitize input as needed
                
                // Write the new content back to the file
                if (file_put_contents($file, $newContent) !== false) {
                    echo "<p>Changes saved successfully.</p>";
                } else {
                    echo "<p>Error saving changes to the file.</p>";
                }
            }

            // Read the content of the file
            $content = file_get_contents($file);
            ?>
            <form method="post">
                <textarea name="content"><?php echo htmlspecialchars($content); ?></textarea>
                <br>
                <button type="submit" name="save">Save Changes</button>
                <input type="hidden" name="file" value="<?php echo htmlspecialchars($file); ?>">
            </form>
            <?php
        } else {
            echo "<p>The selected file is not writable.</p>";
        }
    } else {
        echo "<p>The selected file does not exist.</p>";
    }
} else {
    echo "<p>No file ID provided.</p>";
}
?>