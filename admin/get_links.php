<?php
require 'db.php';

$sql = "SELECT * FROM admin_links";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Output links in a list
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li><a href='" . $row['url'] . "'>" . $row['title'] . "</a></li>";
    }
    echo "</ul>";
} else {
    echo "No links found.";
}
?>