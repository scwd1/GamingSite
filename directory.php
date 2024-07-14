<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directory Listing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #999;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            text-align: center;
        }
        .folder {
            margin-bottom: 10px;
            cursor: pointer;
        }
        .file {
            margin-left: 20px;
            color: #666;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Directory Listing</h2>
        <div class="directory">
            <?php
            // Define root directory path
            $rootDirectory = $_SERVER['DOCUMENT_ROOT'];

            // Define current directory path
            $currentDirectory = __DIR__;

            // Function to recursively get files and folders
            function getFilesAndFolders($directory, $rootDirectory) {
                $output = '';

                // Open the directory
                if ($handle = opendir($directory)) {
                    // Loop through directory contents
                    while (false !== ($entry = readdir($handle))) {
                        if ($entry != "." && $entry != "..") {
                            // Check if entry is a directory
                            if (is_dir($directory . '/' . $entry)) {
                                // Output folder with onclick event to toggle visibility
                                $output .= "<div class='folder' onclick='toggleVisibility(this)'>$entry</div>";
                                // Recursively get files and folders inside this directory
                                $output .= "<div class='files' style='display: none;'>" . getFilesAndFolders($directory . '/' . $entry, $rootDirectory) . "</div>";
                            } else {
                                // Output file with onclick event to open in browser
                                $filePath = str_replace($rootDirectory, '', $directory . '/' . $entry);
                                $filePath = str_replace('\\', '/', $filePath); // Convert backslashes to forward slashes
                                $output .= "<div class='file' onclick='openFile(\"$filePath\")'>$entry</div>";
                            }
                        }
                    }
                    // Close the directory
                    closedir($handle);
                }
                return $output;
            }

            // Output files and folders starting from the defined directory
            echo getFilesAndFolders($currentDirectory, $rootDirectory);
            ?>
        </div>
    </div>

    <script>
        // Function to toggle visibility of files in a folder
        function toggleVisibility(element) {
            var files = element.nextElementSibling;
            if (files.style.display === "none") {
                files.style.display = "block";
            } else {
                files.style.display = "none";
            }
        }

        // Function to open file in browser
        function openFile(filePath) {
            window.open(filePath, '_blank');
        }
    </script>
</body>
</html>