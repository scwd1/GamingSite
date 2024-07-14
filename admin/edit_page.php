<?php
// Include database connection or any necessary functions
include 'db.php';

// Check if page ID is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $page_id = $_GET['id'];

    // Fetch page data based on ID
    $sql = "SELECT * FROM pages WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $page_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if page exists
    if ($result->num_rows > 0) {
        $page = $result->fetch_assoc();
    } else {
        echo "Page not found.";
        exit;
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo "Page ID not provided.";
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Update page data in the database
    $sql = "UPDATE pages SET title = ?, content = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $content, $page_id);
    if ($stmt->execute()) {
        echo "Page updated successfully.";
    } else {
        echo "Error updating page: " . $conn->error;
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
    <title>Edit Page</title>
    <!-- Include any CSS stylesheets -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Edit Page</h2>
    <form method="POST">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo $page['title']; ?>"><br><br>
        
        <label for="content">Content:</label><br>
        <textarea id="content" name="content"><?php echo $page['content']; ?></textarea><br><br>
        
        <button type="submit">Update Page</button>
    </form>
</body>
</html>