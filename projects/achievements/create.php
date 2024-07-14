<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Tables</title>
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
        .success {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Tables</h2>
        <?php
        // Include database connection
        include_once 'db.php';

        // Function to check and create tables if they don't exist
        function createTablesIfNotExist($conn) {
            // SQL queries to check if tables exist
            $sql_check_achievements = "SHOW TABLES LIKE 'achievements'";
            $sql_check_user_achievements = "SHOW TABLES LIKE 'user_achievements'";
            
            // Check if achievements table exists
            $result_achievements = mysqli_query($conn, $sql_check_achievements);
            if (!$result_achievements || mysqli_num_rows($result_achievements) == 0) {
                // Create achievements table
                $sql_create_achievements = "CREATE TABLE achievements (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    title VARCHAR(255) NOT NULL,
                    description TEXT,
                    type VARCHAR(50) NOT NULL,
                    tier INT NOT NULL,
                    points INT NOT NULL,
                    visible BOOLEAN DEFAULT TRUE,
                    admin BOOLEAN DEFAULT FALSE
                )";
                if (mysqli_query($conn, $sql_create_achievements)) {
                    echo "<p class='success'>Achievements table created successfully.</p>";
                } else {
                    echo "<p class='error'>Error creating achievements table: " . mysqli_error($conn) . "</p>";
                }
            }

            // Check if user_achievements table exists
            $result_user_achievements = mysqli_query($conn, $sql_check_user_achievements);
            if (!$result_user_achievements || mysqli_num_rows($result_user_achievements) == 0) {
                // Create user_achievements table
                $sql_create_user_achievements = "CREATE TABLE user_achievements (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT NOT NULL,
                    achievement_id INT NOT NULL,
                    FOREIGN KEY (user_id) REFERENCES users(id),
                    FOREIGN KEY (achievement_id) REFERENCES achievements(id),
                    achieved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
                if (mysqli_query($conn, $sql_create_user_achievements)) {
                    echo "<p class='success'>User Achievements table created successfully.</p>";
                } else {
                    echo "<p class='error'>Error creating user achievements table: " . mysqli_error($conn) . "</p>";
                }
            }
        }

        // Call the function to create tables if they don't exist
        createTablesIfNotExist($conn);
        ?>
    </div>
</body>
</html>