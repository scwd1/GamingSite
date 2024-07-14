<?php
// Include database connectionnnnn
include 'db.php';

// Check if the 'p' parameter is provided and valid
if (isset($_GET['p']) && $_GET['p'] === 'manageusers') {

    // Default SQL query to fetch all users
    $sql = "SELECT * FROM users";

    // Search functionality
    if (!empty($_GET['search'])) {
        $search = $_GET['search'];
        $sql .= " WHERE username LIKE ? OR email LIKE ?";
        $searchParam = "%$search%";
    }

    // Filter by role
    if (!empty($_GET['role'])) {
        $role = $_GET['role'];
        $sql .= " WHERE role = ?";
        $roleParam = $role;
    }

    // Sort functionality
    if (!empty($_GET['sort'])) {
        $sort = $_GET['sort'];
        $sql .= " ORDER BY $sort";
    }

    // Prepare and bind parameters for search and filter
    $stmt = $conn->prepare($sql);
    if (!empty($search)) {
        $stmt->bind_param("ss", $searchParam, $searchParam);
    } else if (!empty($role)) {
        $stmt->bind_param("s", $roleParam);
    }

    // Execute query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if users exist
    if ($result->num_rows > 0) {
        $users = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $users = array();
    }

    // Close statement
    $stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        /* CSS styles here */
    </style>
</head>
<body>
    <h1>User Management</h1>
    
    <!-- Search and filter form -->
    <form method="GET">
        <input type="text" name="search" placeholder="Search by username or email">
        <select name="role">
            <option value="">Filter by Role</option>
            <option value="Admin">Admin</option>
            <option value="User">User</option>
        </select>
        <button type="submit">Search</button>
    </form>
    
    <!-- User list -->
    <div class="user-list">
        <table>
            <thead>
                <tr>
                    <th><a href="?p=manageusers&sort=id">ID</a></th>
                    <th><a href="?p=manageusers&sort=username">Username</a></th>
                    <th><a href="?p=manageusers&sort=email">Email</a></th>
                    <th><a href="?p=manageusers&sort=role">Role</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td>
                            <a href="view_profile.php?id=<?php echo $user['id']; ?>">View Profile</a> |
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a> |
                            <a href="delete_user.php?id=<?php echo $user['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
} else {
    // Redirect or display an error message
    header("Location: error.php");
    exit;
}
?>