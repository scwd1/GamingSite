<?php
session_start();
$current_dir = dirname(__FILE__);

// Check if user is already logged in
if(!isset($_SESSION['user_id'])) {
    // Redirect the user to another page or display a message
    //header("Location: index.php");
    //exit; // Make sure to stop the script execution after redirection
}

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

<link rel="stylesheet" href="layout/2column/style.css">
<main>
    <div class="container">
        <div class="column column1">
            <section>
                <ul class="menu-section">
                    <li class="section-header">
                <?php echo $_SESSION['username']; ?></li>
                <div class="avatar-container">
                        <img src="<?php echo GetUserAvatar($conn, $user['id']) ?>" alt="Avatar">
                </div>
                    <li class="section-header">Basic Info</li>
                    <ul>
                        <li><a href="#">Link 1</a></li>
                        <li><a href="#">Link 2</a></li>
                    </ul>
                    <li class="section-header">Section 2</li>
                    <ul>
                        <li><a href="#">Link 3</a></li>
                        <li><a href="#">Link 4</a></li>
                        <!-- Add more links as needed -->
                    </ul>
                    <!-- Add more sections as needed -->
                </ul>
            </section>
        </div>
        <div class="column column2">
            <section>
    <div class="profile-details-container">
        <div class="profile-details">
            <div class="bio">
                <h3>Bio:</h3>
                <p><?php echo $user['bio']; ?></p>
            </div>
            <div class="gaming-preferences">
                <table class="preference-table">
                    <tr>
                        <th>
                Gaming Preferences</th>
                        <th></th>
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
</section>
<?php
/*} else {
    echo "User not found.";
}*/
?>
            </section>
        </div>
    </div>
</main>