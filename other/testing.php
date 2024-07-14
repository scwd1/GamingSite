<?php
require dirname(__FILE__) . '/header.php';

$sql = "SELECT * FROM site_pages WHERE filename = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $currentPage);
    if ($stmt->execute() && ($result = $stmt->get_result()) && $result->num_rows > 0) {
        $pageData = $result->fetch_assoc();
        $pageTitle = htmlspecialchars($pageData['title'], ENT_QUOTES, 'UTF-8');
        echo "<title>$pageTitle</title>";
        if (!isset($_GET['id'])) {
            echo "No profile selected!";
        } elseif ($pageData['restricted'] > 0) {
            echo "You don't have access to this page.";
        } elseif ($pageData['active'] == 0) {
            echo "<p><strong>This page has been disabled by an administrator.</strong></p>";
        } else {
            $link = '/' . ltrim($pageData['link'], '/');
            $filePath = dirname(__FILE__) . $link;
            if (file_exists($filePath) && is_readable($filePath)) {
                require $filePath;
            } else {
                echo "<p><strong>Page content not found.</strong></p>";
            }
        }
    } else {
        echo "<p><strong>Error executing the query.</strong></p>";
    }
    $stmt->close();
} else {
    echo "<p><strong>Error preparing the statement.</strong></p>";
}

$conn->close();

require dirname(__FILE__) . '/footer.php';
?>