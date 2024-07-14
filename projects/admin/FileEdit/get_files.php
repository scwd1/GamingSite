<?php
// Check if directory parameter is set
if (isset($_GET['directory'])) {
    // Get directory path from parameter
    $directory = $_GET['directory'];

    // Validate directory path
    $directory = realpath($directory);
    if ($directory === false || !is_dir($directory)) {
        header('HTTP/1.1 400 Bad Request');
        echo "Error: Invalid directory path.";
        exit;
    }

    // List files in the directory
    $files = scandir($directory);

    // Output files as list items
    foreach ($files as $file) {
        // Exclude special directories "." and ".."
        if ($file != "." && $file != "..") {
            echo "<li>" . $file . "</li>";
        }
    }
} else {
    // If directory parameter is not set, return an error message
    header('HTTP/1.1 400 Bad Request');
    echo "Error: Directory parameter is missing.";
}
?>