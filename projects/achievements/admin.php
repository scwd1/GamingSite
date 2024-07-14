<?php
// Include database connection
include_once 'db.php';

// Function to fetch all achievements
function getAllAchievements($conn) {
    $sql = "SELECT * FROM achievements";
    $result = mysqli_query($conn, $sql);
    $achievements = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $achievements[] = $row;
        }
    }
    return $achievements;
}

function addAchievement($conn, $title, $description, $type, $tier, $points, $visible, $admin) {
    // SQL query to insert achievement into database
    $sql = "INSERT INTO achievements (title, description, type, tier, points, visible, admin)
            VALUES ('$title', '$description', '$type', $tier, $points, $visible, $admin)";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        return true; // Achievement added successfully
    } else {
        return false; // Error adding achievement
    }
}

// Check if action is specified in the URL
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Process actions
if ($action === 'edit') {
    // Code to handle editing achievement
} elseif ($action === 'remove') {
    // Code to handle removing achievement
} else if ($action === 'create') {
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $title = $_POST['title'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $tier = $_POST['tier'];
        $points = $_POST['points'];
        $visible = isset($_POST['visible']) ? 1 : 0; // Check if checkbox is checked
        $admin = isset($_POST['admin']) ? 1 : 0; // Check if checkbox is checked

        // Add achievement to database
        if (addAchievement($conn, $title, $description, $type, $tier, $points, $visible, $admin)) {
            echo "Achievement added successfully!";
        } else {
            echo "Error adding achievement.";
        }
    }
}

// Fetch all achievements
$achievements = getAllAchievements($conn);

// Display achievements in a table
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <h1>Admin Panel</h1>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Type</th>
                <th>Tier</th>
                <th>Points</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6"><button id="createAchievementBtn">Create Achievement</button></td>
            </tr>
            <?php foreach ($achievements as $achievement): ?>
                <tr>
                    <td><?php echo $achievement['title']; ?></td>
                    <td><?php echo $achievement['description']; ?></td>
                    <td><?php echo $achievement['type']; ?></td>
                    <td><?php echo $achievement['tier']; ?></td>
                    <td><?php echo $achievement['points']; ?></td>
                    <td>
                        <a href="admin.php?action=edit&id=<?php echo $achievement['id']; ?>">Edit</a>
                        <a href="admin.php?action=remove&id=<?php echo $achievement['id']; ?>">Remove</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div id="createAchievementForm" style="display: none;">
        <h2>Create New Achievement</h2>
        <form id="achievementForm">
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title"><br>
            <label for="description">Description:</label><br>
            <textarea id="description" name="description"></textarea><br>
            <label for="type">Type:</label><br>
            <select id="type" name="type">
                <option value="Progress">Progress</option>
                <option value="Milestone">Milestone</option>
                <option value="Social">Social</option>
            </select><br>
            <label for="tier">Tier:</label><br>
            <input type="number" id="tier" name="tier"><br>
            <label for="points">Points:</label><br>
            <input type="number" id="points" name="points"><br>
            <label for="visible">Visible:</label>
            <input type="checkbox" id="visible" name="visible"><br>
            <label for="admin">Admin:</label>
            <input type="checkbox" id="admin" name="admin"><br>
            <input type="submit" value="Create">
        </form>
    </div>

    <script>
        document.getElementById('createAchievementBtn').addEventListener('click', function() {
            document.getElementById('createAchievementForm').style.display = 'block';
        });

        document.getElementById('achievementForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var form = this;
            var formData = new FormData(form);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'create_achievement.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                    form.reset();
                    document.getElementById('createAchievementForm').style.display = 'none';
                    // Refresh the achievement list if needed
                }
            };
            xhr.send(formData);
        });
    </script>
</body>
</html>