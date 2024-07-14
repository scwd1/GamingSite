<?php
session_start();

// Include database connection file
include 'db.php';

// Check if the form fields are set and not empty
if(isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    // Retrieve the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement to fetch the user's information
    $sql = "SELECT * FROM users WHERE username = ?";

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    
    $stmt->bind_param("s", $username);
    if (!$stmt->bind_param("s", $username)) {
        die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
    }
    
    if (!$stmt->execute()) {
        die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    if (!$result) {
        die("Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    // Check if the username exists in the database
    if($result->num_rows == 1) {
        // Fetch the user's data
        $user = $result->fetch_assoc();

        // Verify the password
        if(password_verify($password, $user['password'])) {
            // Password is correct, set session variables and redirect to dashboard
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            // Password is incorrect, set error message
            $_SESSION['error'] = "Invalid username or password.";
            header("Location: login.php");
            exit();
        }
    } else {
        // Username does not exist, set error message
        $_SESSION['error'] = "Invalid username or password.";
        header("Location: login.php");
        exit();
    }
} else {
    // Form fields are not set or empty, set error message
    $_SESSION['error'] = "Username and password are required.";
    header("Location: login.php");
    exit();
}
?>