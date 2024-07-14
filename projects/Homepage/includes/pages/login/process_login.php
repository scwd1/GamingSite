<?php
if (!file_exists("../../db.php") || !file_exists("../../functions.php")) {
    // Required files are missing, handle the error
    echo json_encode(array('success' => false, 'message' => 'Required files are missing'));
    exit;
}
require("../../db.php");
require("../../functions.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Authenticate user using username and password
    $user = authenticateUser($username, $password);
    
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        // CSRF token validation failed, handle the error
        echo json_encode(array('success' => false, 'message' => 'CSRF token validation failed'));
        exit;
    }
    if ($user !== false) {
        // User is authenticated, proceed with login
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['adminlevel'] = $user['admin'];
        
        // Redirect the user to a different page
        header("Location: ../../../index.php");
        exit; // Ensure that subsequent code is not executed after redirection
    } else {
        // Authentication failed
        echo json_encode(array('success' => false, 'message' => 'Authentication failed'));
    }
}
?>