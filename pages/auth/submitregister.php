<?php
// Include database connection file
include 'db.php';

// Retrieve form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validate input
if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    echo "All fields are required.";
} elseif ($password !== $confirm_password) {
    echo "Passwords do not match.";
} else {
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute SQL statement to insert user into database
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "Registration successful. You can now <a href='login.php'>login</a>.";
    } else {
        echo "Error: " . $conn->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}
?>