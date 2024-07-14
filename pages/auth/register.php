<?php
include 'db.php'; // Include the database connection file

// Start the session
session_start();

// Query to retrieve the page title from the database
$title_query = "SELECT value FROM site_settings WHERE name = 'page_title'";
$title_result = $conn->query($title_query);
$page_title = "Kaonashi Cove"; // Default title if no data is available in the database

// Check if the query was successful and rows were returned
if ($title_result && $title_result->num_rows > 0) {
    $title_row = $title_result->fetch_assoc();
    $page_title = $title_row['value'];
}

// Check if the user is logged in
if(isset($_SESSION['username'])) {
    // If the user is logged in, display their username
    $login_link = $_SESSION['username'];
} else {
    // If the user is not logged in, display "Login"
    $login_link = "Login";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title> <!-- Dynamic page title -->
    <link rel="stylesheet" href="style.css">
    <script>
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
<!-- Add or update in your HTML file -->
<div class="header">
    <div class="header-overlay">
        <h1>Kaonashi Cove</h1>
        <div class="login-box">
            <!-- Display the login link -->
            <a href="<?php if(isset($_SESSION['username'])) { echo '#'; } else { echo 'login.html'; } ?>"><?php echo $login_link; ?></a>
        </div>
    </div>
    <img src="header_image.jpg" alt="Header Image">
</div>

<div class="navbar" id="myNavbar">
    <?php
    $sql = "SELECT url, text FROM navbar_links";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<a href="' . $row['url'] . '">' . $row['text'] . '</a>';
        }
    } else {
        echo '<a href="/">Home</a>';
        echo '<a href="#">Forum</a>';
        echo '<a href="#">Events</a>';
        echo '<a href="#">Gallery</a>';
        echo '<a href="#">Contact</a>';
    }
    ?>
    <a href="javascript:void(0);" class="icon" onclick="toggleMenu()">
        &#9776;
    </a>
</div>

<!-- JavaScript to toggle responsive navbar -->
<script>
    function toggleMenu() {
        var x = document.getElementById("myNavbar");
        if (x.className === "navbar") {
            x.className += " responsive";
        } else {
            x.className = "navbar";
        }
    }
</script>

</body>
</html>
<h2>User Registration</h2>
    <form action="submitregister.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
         
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
        
        <input type="submit" value="Register">
    </form>
<div class="footer">
    <p>Kaonashi Cove © <?php echo date("Y"); ?></p>
</div>
</body>
</html>