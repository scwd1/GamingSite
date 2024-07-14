<?php
session_start();

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kaonashi_cove";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to set a long-lived remember me cookie
function setRememberMeCookie($userId) {
    $token = bin2hex(random_bytes(16)); // Generate a random token
    $expiry = time() + (30 * 24 * 60 * 60); // 30 days expiry
    setcookie('remember_me', $userId . ':' . $token, $expiry, '/');
}

// Function to clear the remember me cookie
function clearRememberMeCookie() {
    setcookie('remember_me', '', time() - 3600, '/'); // Expire immediately
}

// Function to authenticate user using username, password, and optional fingerprint
function authenticateUser($username, $password, $fingerprint = '') {
    global $conn;
    // SQL injection prevention
    $username = mysqli_real_escape_string($conn, $username);

    // Prepare SQL query to fetch user from database
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists, verify password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct
            // Check fingerprint if provided
            if ($fingerprint !== '') {
                // Code to verify fingerprint (replace with your own implementation)
                if ($fingerprint === $user['fingerprint']) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }
    }
    return false;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fingerprint = isset($_POST['fingerprint']) ? $_POST['fingerprint'] : '';

    // Authenticate user using username, password, and fingerprint
    $authenticated = authenticateUser($username, $password, $fingerprint);

    if ($authenticated) {
        // User is authenticated, proceed with login
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        // Check if "Remember Me" is checked
        if (isset($_POST['remember_me'])) {
            setRememberMeCookie($user['id']);
        }
        echo json_encode(array('success' => true));
    } else {
        // Authentication failed
        echo json_encode(array('success' => false, 'message' => 'Authentication failed'));
    }
}

// Close the database connection
$conn->close();
?>