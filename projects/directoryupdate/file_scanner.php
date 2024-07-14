<?php
include("db.php");

// Create table for files if not exist
$sql = "CREATE TABLE IF NOT EXISTS files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    size INT,
    folder_id INT,
    FOREIGN KEY (folder_id) REFERENCES folders(id)
)";
$conn->query($sql);

// Create table for folders if not exist
$sql = "CREATE TABLE IF NOT EXISTS folders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255)
)";
$conn->query($sql);

// Get the directory path
$directory = $_POST["directory"];

// Insert entry for root folder
$sql = "INSERT INTO folders (name) VALUES ('$directory')";
$conn->query($sql);
$folder_id = $conn->insert_id;

// Insert entries for files
insertFiles($directory, $folder_id, $conn);

// Display the inserted entries
$sql = "SELECT * FROM files";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "Files:<br>";
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Name: " . $row["name"] . " - Size: " . $row["size"] . " - Folder ID: " . $row["folder_id"] . "<br>";
    }
} else {
    echo "No files found.<br>";
}

$sql = "SELECT * FROM folders";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<br>Folders:<br>";
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Name: " . $row["name"] . "<br>";
    }
} else {
    echo "No folders found.<br>";
}

// Close connection
$conn->close();

// Function to recursively insert files
function insertFiles($directory, $folder_id, $conn) {
    $files = scandir($directory);
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            $fullPath = $directory . "/" . $file;
            if (is_file($fullPath)) {
                $name = pathinfo($file, PATHINFO_FILENAME);
                $size = filesize($fullPath);
                // Check if file already exists
                $sql = "SELECT * FROM files WHERE name='$name' AND folder_id=$folder_id";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    // If file exists, check if size has changed
                    if ($row["size"] != $size) {
                        // Update size
                        $sql = "UPDATE files SET size=$size WHERE id=" . $row["id"];
                        $conn->query($sql);
                    }
                } else {
                    // Insert new file
                    $sql = "INSERT INTO files (name, size, folder_id) VALUES ('$name', $size, $folder_id)";
                    $conn->query($sql);
                }
            } elseif (is_dir($fullPath)) {
                $sql = "INSERT INTO folders (name) VALUES ('$file')";
                $conn->query($sql);
                $new_folder_id = $conn->insert_id;
                insertFiles($fullPath, $new_folder_id, $conn);
            }
        }
    }
}
?>