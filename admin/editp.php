<?php
require 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit PHP File</title>
    <style>
        ul {
            list-style-type: none;
            padding-left: 20px;
        }
        
        li {
            margin-bottom: 5px;
        }
        
        a {
            text-decoration: none;
            color: #f8f9fa;
        }
        
        a:hover {
            text-decoration: underline;
        }
        
        textarea {
            width: 100%;
            height: 300px;
            margin-top: 10px;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }
        
        button {
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        button:hover {
            background-color: #0056b3;
        }
        
        #edit-area {
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #ccc;
            border-radius: 4px;
            display: none;
        }
    </style>
    <script>
        function loadEditArea(file) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Hide all edit areas
                    var editAreas = document.getElementsByClassName("edit-area");
                    for (var i = 0; i < editAreas.length; i++) {
                        editAreas[i].style.display = "none";
                    }
                    // Find the edit area for the clicked file and display it
                    var editArea = document.getElementById("edit-area-" + file);
                    editArea.innerHTML = this.responseText;
                    editArea.style.display = "block";
                }
            };
            xhttp.open("GET", "editp2.php?file=" + file, true);
            xhttp.send();
        }
    </script>
</head>
<body>
    <h1>Edit PHP File</h1>
    <?php
    function showError($message) {
        echo '<p class="error">' . $message . '</p>';
    }

    $directory = ".";
    $phpFiles = glob($directory . "/*.*");

    if (count($phpFiles) > 0) {
        echo "<ul>";
        foreach ($phpFiles as $phpFile) {
            $fileName = urlencode(basename($phpFile));
            echo "<li>- <a href=\"#\" onclick=\"loadEditArea('" . $fileName . "')\">" . htmlspecialchars($fileName) . "</a>";
            echo "<div class='edit-area' id='edit-area-" . $fileName . "'></div></li>";
        }
        echo "</ul>";
    } else {
        showError("No PHP files found in the directory.");
    }
    ?>
</body>
</html>
<?php
require 'footer.php';
?>