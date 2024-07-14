<?php
// Check if user is authenticated as admin (You would implement your own authentication mechanism)

// Check if file parameter is provided
if (isset($_GET['file'])) {
    $file = $_GET['file'];
    
    // Get file content
    $file_path = "./" . $file; // Change this to your directory path
    $file_handle = fopen($file_path, "r"); // Open file in read mode
    
    if ($file_handle) {
        // Read file content line by line and store it in a variable
        $file_content = "";
        while (!feof($file_handle)) {
            $file_content .= fgets($file_handle);
        }
        fclose($file_handle); // Close file handle
        
        // Display file content in a textarea for editing
        echo "<h1>Edit File: $file</h1>";
        echo "<form action='save_file.php' method='post'>";
        echo "<input type='hidden' name='file' value='" . htmlspecialchars($file) . "'>";
        echo "<textarea name='content' rows='10' cols='50'>" . htmlspecialchars($file_content) . "</textarea><br>"; // Populate textarea with file content
        echo "<input type='submit' value='Save'>";
        echo "</form>";
    } else {
        echo "Unable to open file.";
    }
} else {
    echo "File not specified.";
}
?>