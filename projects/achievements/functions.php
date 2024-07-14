<?php
// Include your database connection file
include 'db_connect.php';

// Function to add a new achievement
function addAchievement($identifier, $type, $title, $description, $tier, $points, $visible, $admin) {
    global $conn; // Access the global connection variable

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO achievements (identifier, type, title, description, tier, points, visible, admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiiii", $identifier, $type, $title, $description, $tier, $points, $visible, $admin);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo "Achievement added successfully";
    } else {
        echo "Error adding achievement: " . $conn->error;
    }

    // Close statement (no need to close connection as it's global)
    $stmt->close();
}

function removeAchievement($achievementId) {
    global $conn;

    // Prepare the SQL statement to delete the achievement
    $sql = "DELETE FROM achievements WHERE id = ?";

    // Prepare and bind parameter
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $achievementId);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo "Achievement removed successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the statement (connection remains open for subsequent function calls)
    $stmt->close();
}

function editAchievement($achievementId, $newTitle, $newDescription, $newTier, $newPoints, $newVisible, $newAdmin) {
    global $conn;

    // Prepare the SQL statement to update the achievement
    $sql = "UPDATE achievements SET title = ?, description = ?, tier = ?, points = ?, visible = ?, admin = ? WHERE id = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiiii", $newTitle, $newDescription, $newTier, $newPoints, $newVisible, $newAdmin, $achievementId);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo "Achievement updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the statement (connection remains open for subsequent function calls)
    $stmt->close();
}

function displayAAchievements() {
    global $conn;

    // Prepare the SQL statement to retrieve visible achievements
    $sql = "SELECT * FROM achievements WHERE visible = 1";

    // Execute the statement
    $result = $conn->query($sql);

    // Check if there are any achievements
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "Title: " . $row["title"] . "<br>";
            echo "Description: " . $row["description"] . "<br>";
            // Add logic to display progress bar for progress-based achievements
            if ($row["type"] === "progress") {
                echo "Progress: " . $row["progress"] . "%<br>";
            }
            // Add logic to display difficulty tier and custom point values
            echo "Difficulty Tier: " . $row["tier"] . "<br>";
            echo "Points: " . $row["points"] . "<br>";
            // Add logic to display closest three achievements on top
            echo "<br>";
        }
    } else {
        echo "No visible achievements found";
    }
}

// Function to earn an achievement
function earnAchievement($userId, $achievementId) {
    // Include your database connection here

    // Check if the achievement is already earned by the user
    $sql_check = "SELECT * FROM user_achievements WHERE user_id = :userId AND achievement_id = :achievementId";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute(['userId' => $userId, 'achievementId' => $achievementId]);
    $existing_achievement = $stmt_check->fetch();

    if ($existing_achievement) {
        // Achievement already earned, return without doing anything
        return;
    }

    // Fetch the achievement details
    $sql_achievement = "SELECT * FROM achievements WHERE id = :achievementId";
    $stmt_achievement = $pdo->prepare($sql_achievement);
    $stmt_achievement->execute(['achievementId' => $achievementId]);
    $achievement = $stmt_achievement->fetch();

    if (!$achievement) {
        // Achievement not found, return without doing anything
        return;
    }

    // Check if the achievement is hidden
    if ($achievement['visible'] == 0) {
        // Check if the user has discovered the hidden achievement
        $sql_discovered = "SELECT * FROM discovered_achievements WHERE user_id = :userId AND achievement_id = :achievementId";
        $stmt_discovered = $pdo->prepare($sql_discovered);
        $stmt_discovered->execute(['userId' => $userId, 'achievementId' => $achievementId]);
        $discovered_achievement = $stmt_discovered->fetch();

        if (!$discovered_achievement) {
            // The achievement is hidden and not yet discovered by the user, so we won't award it yet
            return;
        }
    }

    // Check if the user meets the requirements to earn the achievement
    // Logic to check if user meets requirements goes here
    $user_meets_requirements = true; // Placeholder

    if ($user_meets_requirements) {
        // Insert a new record into the user_achievements table to mark the achievement as earned
        $sql_insert = "INSERT INTO user_achievements (user_id, achievement_id, date_earned) VALUES (:userId, :achievementId, NOW())";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->execute(['userId' => $userId, 'achievementId' => $achievementId]);

        // Optionally, update the user's total points based on the achievement's point value
    }
}

// Function to display achievements for a user
function displayAchievements($userId) {
    // Include your database connection here

    // Fetch the user's earned achievements
    $sql = "SELECT achievements.id, achievements.title, achievements.description FROM user_achievements 
            JOIN achievements ON user_achievements.achievement_id = achievements.id
            WHERE user_achievements.user_id = :userId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['userId' => $userId]);
    $achievements = $stmt->fetchAll();

    // Check if the user has earned any achievements
    if (!$achievements) {
        echo "No achievements earned yet.";
        return;
    }

    // Display the user's achievements
    echo "<ul>";
    foreach ($achievements as $achievement) {
        echo "<li>";
        echo "<strong>" . $achievement['title'] . "</strong>: " . $achievement['description'];
        echo "</li>";
    }
    echo "</ul>";
}
?>