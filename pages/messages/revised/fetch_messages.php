<?php
// Include your database connection file
require_once 'db.php';

// Set the default page number and page size
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = isset($_GET['size']) ? $_GET['size'] : 10;

// Calculate the offset based on the page number and page size
$offset = ($page - 1) * $pageSize;

// Query to fetch messages from the database
$query = "SELECT * FROM messages ORDER BY date DESC LIMIT $offset, $pageSize";

// Perform the query
$result = mysqli_query($conn, $query);

// Initialize an array to store the messages
$messages = array();

// Check if the query was successful
if ($result) {
    // Fetch messages from the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Add each message to the messages array
        $messages[] = array(
            'id' => $row['id'],
            'sender' => $row['sender_id'],
            'content' => $row['body'],
            'timestamp' => $row['date']
        );
    }
    
    // Free the result set
    mysqli_free_result($result);
    
    // Send the messages as JSON response
    echo json_encode(array('success' => true, 'messages' => $messages));
} else {
    // If the query failed, send an error response
    echo json_encode(array('success' => false, 'error' => 'Failed to fetch messages: ' . mysqli_error($conn)));
}

// Close the database connection
mysqli_close($conn);
?>