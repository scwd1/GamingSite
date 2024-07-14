<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Directory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
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
        p {
            margin-bottom: 20px;
        }
        .file, .folder {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            cursor: pointer; /* Add cursor pointer to indicate clickable */
        }
        .file:hover, .folder:hover {
            background-color: #f0f0f0;
        }
        .file-options, .folder-options {
            display: flex;
            gap: 10px;
        }
        .folder-contents {
            display: none; /* Initially hide folder contents */
            padding-left: 20px; /* Indent contents to visually show hierarchy */
        }
        .expanded .folder-contents {
            display: block; /* Show folder contents when expanded */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>File Directory</h2>
        <?php
        function displayDirectory($directory) {
            // Retrieve list of files and folders
            $files = scandir($directory);
            foreach ($files as $file) {
                if ($file != "." && $file != "..") {
                    echo "<div class='";
                    echo is_dir($directory . '/' . $file) ? "folder" : "file";
                    echo "'>";
                    echo "<span class='folder-name'>$file</span>";
                    if (is_dir($directory . '/' . $file)) {
                        // Recursively display contents of sub-folder
                        echo "<div class='folder-contents'>";
                        displayDirectory($directory . '/' . $file);
                        echo "</div>";
                    } else {
                        // Display file options
                        echo "<div class='file-options'>";
                        echo "<a href='$directory/$file' target='_blank'>View</a>";
                        echo "<a href='#'>Edit</a>";
                        echo "<a href='#'>Delete</a>";
                        echo "</div>";
                    }
                    echo "</div>";
                }
            }
        }

        // Display the directory starting from the current directory
        displayDirectory(__DIR__);
        ?>
    </div>
    <script>
        // Add event listener to folders for expanding/collapsing
        document.querySelectorAll('.folder').forEach(folder => {
            folder.addEventListener('click', () => {
                // Toggle the 'expanded' class on the folder
                folder.classList.toggle('expanded');
            });
        });
    </script>
</body>
</html>