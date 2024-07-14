<?php

require 'db.php';
// Fetch statistics from the database
$usersCount = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0] ?? 0;
/*$newRegistrationsToday = $conn->query("SELECT COUNT(*) FROM users WHERE registration_date = CURDATE()")->fetch_row()[0] ?? 0;
$activeSessions = $conn->query("SELECT COUNT(*) FROM sessions WHERE last_activity > NOW() - INTERVAL 1 HOUR")->fetch_row()[0] ?? 0; */

// Fetch content management data from the database
$pagesCount = $conn->query("SELECT COUNT(*) FROM site_pages")->fetch_row()[0] ?? 0;

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* CSS styles here */
    </style>
</head>
<body>
    <div class="container">
        <div class="section">
            <h2>Statistics</h2>
            <div class="card">
                <p>Total Users: <?php echo $usersCount; ?> - <a href="usermanager.php?p=manageusers">Edit Users</a></p>
                <p>New Registrations Today: <?php echo $newRegistrationsToday; ?></p>
                <p>Active Sessions: <?php echo $activeSessions; ?></p>
            </div>
        </div>
        
        <div class="section">
            <h2>Content Management</h2>
            <div class="card">
                <p>Pages: <?php echo $pagesCount; ?></p>
                <p>Blog Posts: <?php echo $blogPostsCount; ?></p>
                <p>Categories: <?php echo $categoriesCount; ?></p>
            </div>
        </div>
        
        <div class="section">
            <h2>Settings</h2>
            <div class="card">
                <p>General Settings</p>
                <p>Security Settings</p>
                <p>Email Settings</p>
            </div>
        </div>
    </div>
</body>
</html>