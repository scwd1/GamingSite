<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manager</title>
</head>
<body>
    <h1>File Manager</h1>
    <form action="process.php" method="post">
        <label for="directory">Select or enter directory:</label>
        <select name="directory" id="directory">
            <option value="">Select directory</option>
            <?php
            // Get directory options
            $directories = scandir(".");
            foreach ($directories as $dir) {
                if (is_dir($dir) && $dir != "." && $dir != "..") {
                    echo "<option value='$dir'>$dir</option>";
                }
            }
            ?>
            <option value=".">Current directory</option>
            <option value="..">Parent directory</option>
        </select>
        <input type="text" id="customDirectory" name="customDirectory" placeholder="Or enter custom directory path">
        <button type="submit">Scan Directory</button>
    </form>
</body>
</html>