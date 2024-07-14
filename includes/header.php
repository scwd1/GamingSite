<?php
// Include necessary files
include 'db.php'; // Include database connection
session_start(); // Start the session
require 'functions.php'; // Include custom functions

// Get the current directory path
$current_dir = dirname(__FILE__);

// Check if the user is logged in, set login link accordingly
$login_link = LoginCheck() ? $_SESSION['username'] : "Login";

// Retrieve site settings from the database
$site_settings = $conn->query("SELECT name, value FROM site_settings")->fetch_all(MYSQLI_ASSOC);

// If no settings found, display a message
if (empty($site_settings)) {
    echo "No settings found";
} else {
    // Convert the site settings into an associative array
    $site_settings = array_column($site_settings, 'value', 'name');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="messages.css">
    <script>
    // JavaScript function to toggle the responsive navbar
    function toggleMenu() {
        var x = document.getElementById("myNavbar");
        if (x.className === "navbar") {
            x.className += " responsive";
        } else {
            x.className = "navbar";
        }
    }
    </script>
</head>
<body>
<div class="header">
    <div class="header-overlay">
        <h1>Kaonashi Cove</h1>
        <div class="login-box">
            <!-- Display the login link -->
  <a href="<?php echo isset($_SESSION['username']) ? 'testing.php/?id=' . GetUserID($conn, $_SESSION['username']) : 'login.php'; ?>"><?php echo $login_link; ?></a>
        </div>
    </div>
    <img src="<?php $current_dir ?>/header_image.jpg" alt="Header Image">
</div>

<div class="navbar" id="myNavbar">
    <?php
    // Retrieve navbar links from the database
    $sql = "SELECT url, text FROM navbar_links";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        // Output navbar links
        while ($row = $result->fetch_assoc()) {
            echo '<a href="' . ($site_settings['url'] ?? '') . $row['url'] . '">' . $row['text'] . '</a>';
        }
    } else {
        // If no navbar links found, display default links
        echo '<a href="/">Home</a><a href="#">Forum</a><a href="#">Events</a><a href="#">Gallery</a><a href="#">Contact</a>';
    }
    // If user is logged in, display additional links
    if(isset($_SESSION['username'])) {
        echo '<a href="view_messages.php">View Messages</a><a href="logout.php">Logout</a>';
    }
    ?>
    <!-- Icon for toggling responsive navbar -->
    <a href="javascript:void(0);" class="icon" onclick="toggleMenu()">&#9776;</a>
</div>

<!-- JavaScript to toggle responsive navbar -->
<script>
// JavaScript function to toggle the responsive navbar
function toggleMenu() {
    document.getElementById("myNavbar").classList.toggle("responsive");
}
</script>

</body>
</html>

<?php
/* // Sanitize and validate the current page name
$currentPage = basename($_SERVER['PHP_SELF']);

// Define allowed pages
$allowedPages = array('profile.php', 'login.php', 'index.php', 'testing.php'); // Add more allowed pages as needed

// Check if the current page is allowed
if (!in_array($currentPage, $allowedPages)) {
    // Redirect to an error page or display an error message
    header("Location: error.php");
    exit; // Stop script execution to prevent further processing
}*/

/*$sql = "SELECT page_name, page_url FROM allowed_pages";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$allowedPages = [];
while ($row = $result->fetch_assoc()) {
    $allowedPages[] = $row;
}

// Get the current URL path
$currentURL = $_SERVER['REQUEST_URI'];

// Page authorization
$isAllowed = false;
foreach ($allowedPages as $page) {
    if ($currentURL === $page['page_url'] || strpos($currentURL, $page['page_url'] . '/') === 0) {
        $isAllowed = true;
        break;
    }
}

if (!$isAllowed) {
    // Redirect to an error page or display a message indicating unauthorized access
    //header("Location: /error.php");
    //exit;
}*/
?>