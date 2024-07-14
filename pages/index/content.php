<!-- Grid Content Section -->
<div class="flex-content">
    <div class="flex-container">
        <?php
        // Retrieve grid content from the database
        $sql = "SELECT title, body FROM site_content WHERE section='grid' AND active = 1 ORDER BY id ASC LIMIT 3";
        $result = $conn->query($sql);

        // Check if the query was successful and rows were returned
        if ($result && $result->num_rows > 0) {
            // Output data of each row
            $count = 0;
            while($row = $result->fetch_assoc()) {
                // Determine the width of the flex item based on the count
                $width_class = ($count == 0) ? 'full-width' : 'half-width';
                
                // Output the flex item with appropriate width
                echo '<div class="flex-item ' . $width_class . '">';
                echo "<h2>" . $row["title"]. "</h2>";
                echo "<p>" . $row["body"]. "</p>";
                echo '</div>';
                
                // Increment the count
                $count++;
            }
        } else {
            // If no grid content available, display a message
            echo "No grid content available.";
        }
        ?>
    </div>
</div>