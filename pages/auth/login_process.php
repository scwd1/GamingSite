<?php
// Include database connection file
include 'db.php';

// Retrieve form data
$username = $_POST['username'];
$password = $_POST['password'];

// Validate input
if (empty($username) || empty($password)) {
    $_SESSION['error'] = "Username and password are required.";
    header("Location: login.php");
    exit();
}

// Prepare and execute SQL statement to retrieve user from database
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Check if the username exists in the database
if($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    // Debug: Output the hashed password from the database
    // echo "Hashed password from database: " . $user['password'] . "<br>";
    // Verify the password
    if(password_verify($password, $user['password'])) {
        // Password is correct, set session variables and redirect to dashboard
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        // Incorrect password, redirect back to login page with error message
        $_SESSION['error'] = "Incorrect password.";
        header("Location: login.php");
        exit();
    }
} else {
    // Username does not exist, redirect back to login page with error message
    $_SESSION['error'] = "User not found.";
    header("Location: login.php");
    exit();
}

// Close statement and database connection
$stmt->close();
$conn->close();
?>