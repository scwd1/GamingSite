<?php
// Validate and sanitize the user ID parameter
$user_id = isset($_GET['id']) ? intval($_GET['id']) : null; // Ensure it's an integer
if ($user_id <= 0) {
    // Invalid user ID, redirect or show an error message
    //header("Location: error.php");
    //exit;
}

// Prepare SQL statement with parameterized query
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if user data exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    // Display user profile details
    ?>
    <div class="profile-container">
        <p></p><h2><?php echo isset($user['username']) ? htmlspecialchars($user['username']) : ''; ?></h2></p>
        <div class="avatar-container">
            <div class="avatar">
                <img src="<?php echo isset($user['id']) ? htmlspecialchars(GetUserAvatar($conn, $user['id'])) : ''; ?>" alt="Avatar">
            </div>
        </div>
        <div class="profile-details-container">
            <div class="profile-details">
                <div class="bio">
                    <h3>Bio:</h3>
                    <p><?php echo isset($user['bio']) ? htmlspecialchars($user['bio']) : ''; ?></p>
                </div>
                <!-- Display gaming preferences and platforms securely -->
                <div class="gaming-preferences">
                    <h3>Gaming Preferences:</h3>
                    <table class="preference-table">
                        <!-- Add more gaming preferences as needed -->
                        <tr>
                            <td>Action</td>
                            <td><?php echo isset($user['gaming_preference1']) ? htmlspecialchars($user['gaming_preference2']) : ''; ?></td>
                        </tr>
                        <!-- Add other gaming preferences -->
                    </table>
                </div>
                <div class="gaming-platforms">
                    <h3>Gaming Platforms:</h3>
                    <table class="preference-table">
                        <!-- Add more gaming platforms as needed -->
                        <tr>
                            <td>PC</td>
                            <td><?php echo isset($user['gaming_platform_pc']) ? htmlspecialchars($user['gaming_platform_pc']) : ''; ?></td>
                        </tr>
                        <!-- Add other gaming platforms -->
                    </table>
                </div>
                <div class="social-media">
                    <h3>Social Media & Streaming Apps:</h3>
                    <p>Facebook: <?php echo isset($user['facebook']) ? htmlspecialchars($user['facebook']) : ''; ?></p>
                    <p>Twitter: <?php echo isset($user['twitter']) ? htmlspecialchars($user['twitter']) : ''; ?></p>
                    <!-- Add more social media and streaming apps as needed -->
                </div>
            </div>
        </div>
    </div>
<?php
} else {
    // No user data found
    header("Location: error.php");
    exit;
}
?>