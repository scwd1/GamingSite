<?php
$current_dir = dirname(__FILE__);
require $current_dir . '/../header.php';
// Check if the user is logged in
/*if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: /../login.php");
    exit();
}*/

//==========================================
//==========================================
/* ADD A GET CHECK TO DISPLAY OTHER PEOPLE'S PROFILES
THEN CHANGE THE USER ID TO THE PROFILE ID
*/
//==========================================
//==========================================

// Retrieve user data from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if user data exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
}
    
?>

<div class="profile-container">
    <p></p><h2><?php echo $_SESSION['username']; ?></h2></p>
    <div class="avatar-container">
        <div class="avatar">
            <img src="<?php echo GetUserAvatar($conn, $user['id']) ?>" alt="Avatar">
        </div>
    </div>
    <div class="profile-details-container">
        <div class="profile-details">
            <div class="bio">
                <h3>Bio:</h3>
                <p><?php echo $user['bio']; ?></p>
            </div>
            <div class="gaming-preferences">
                <h3>Gaming Preferences:</h3>
                <table class="preference-table">
                    <tr>
                        <th>Category</th>
                        <th>Preference</th>
                    </tr>
                    <tr>
                        <td>Action</td>
                        <td><?php echo $user['gaming_preference_action']; ?></td>
                    </tr>
                    <tr>
                        <td>Adventure</td>
                        <td><?php echo $user['gaming_preference_adventure']; ?></td>
                    </tr>
                    <tr>
                        <td>Role-Playing Games (RPGs)</td>
                        <td><?php echo $user['gaming_preference_rpg']; ?></td>
                    </tr>
                    <!-- Add more gaming preferences as needed -->
                </table>
            </div>
            <div class="gaming-platforms">
                <h3>Gaming Platforms:</h3>
                <table class="preference-table">
                    <tr>
                        <th>Platform</th>
                        <th>Preference</th>
                    </tr>
                    <tr>
                        <td>PC</td>
                        <td><?php echo $user['gaming_platform_pc']; ?></td>
                    </tr>
                    <tr>
                        <td>PlayStation</td>
                        <td><?php echo $user['gaming_platform_playstation']; ?></td>
                    </tr>
                    <!-- Add more gaming platforms as needed -->
                </table>
            </div>
            <div class="social-media">
                <h3>Social Media & Streaming Apps:</h3>
                <p>Facebook: <?php echo $user['facebook']; ?></p>
                <p>Twitter: <?php echo $user['twitter']; ?></p>
                <!-- Add more social media and streaming apps as needed -->
            </div>
        </div>
    </div>
</div>
<?php
/*} else {
    echo "User not found.";
}*/
$stmt->close();
$conn->close();
include '../footer.php';
?>