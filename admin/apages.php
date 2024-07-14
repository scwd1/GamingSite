<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pages</title>
    <!-- Include CSS stylesheets -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Admin Pages Section</h1>
        <div class="overview">
            <!-- Display overview and stats -->
            <p>Here, you can manage website pages, including creating, editing, and deleting pages.</p>
            <!-- Display relevant stats or information -->
        </div>
        <div class="navigation">
            <ul>
                <li><a href="admin_pages.php?action=create">Create Page</a></li>
                <li><a href="apages.php?action=edit">Edit Page</a></li>
                <li><a href="admin_pages.php?action=delete">Delete Page</a></li>
            </ul>
        </div>
        <div class="content">
            <?php
            // Check if action is set and load the corresponding sub-page
            if (isset($_GET['action'])) {
                $action = $_GET['action'];
                if ($action === 'create') {
                    include 'create_page.php';
                } elseif ($action === 'edit') {
                    include 'edit_page.php';
                } elseif ($action === 'delete') {
                    include 'delete_page.php';
                } else {
                    echo "Invalid action.";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>