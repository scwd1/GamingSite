<?php
// Include database connection
include 'db.php';

if (!isset($_GET['p'], $_GET['action'], $_GET['id']) || empty($_GET['p']) || empty($_GET['action']) || empty($_GET['id'])) {
    echo "Page, action, or user ID not provided.";
    exit;
}

if ($_GET['p'] != 'manageusers') {
    echo "Invalid page.";
    exit;
}

if ($_GET['action'] != 'edituser') {
    echo "Invalid action.";
    exit;
}

$user_id = $_GET['id'];

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "User not found.";
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Update user data in the database
    $sql = "UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $email, $role, $user_id);
    if ($stmt->execute()) {
        echo "User information updated successfully.";
    } else {
        echo "Error updating user information: " . $conn->error;
    }

    // Close the prepared statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        /* CSS styles here */
    </style>
</head>
<body>
    <h1>Edit User</h1>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>"><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>"><br><br>
        
        <label for="role">Role:</label>
        <select id="role" name="role">
            <option value="Admin" <?php if ($user['role'] == 'Admin') echo 'selected'; ?>>Admin</option>
            <option value="User" <?php if ($user['role'] == 'User') echo 'selected'; ?>>User</option>
        </select><br><br>
        
        <button type="submit">Update User</button>
    </form>
</body>
</html>