<?php
/*$profilelinks = array(
    "path1" => $_SERVER['DOCUMENT_ROOT'] . "/path/to/your/file1.php",
    "path2" => $_SERVER['DOCUMENT_ROOT'] . "/path/to/your/file2.php",
    "path3" => $_SERVER['DOCUMENT_ROOT'] . "/path/to/your/file3.php"
);*/

/*
===========================
Global Variables defined here.
===========================
*/

// Check if $_SERVER['DOCUMENT_ROOT'] is set and not empty
if(isset($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['DOCUMENT_ROOT'])) {
    // Define array to store profile links
    $globallinks = array();
    
    // Define paths relative to the document root
    $paths = array(
        "database" => "projects/Homepage/includes/db.php",
        "header" => "projects/Homepage/includes/head.php",
        "nav" => "projects/Homepage/includes/nav.php",
        "footer" => "projects/Homepage/includes/foot.html",
        "home" => "/"
    );
    
    // Loop through paths and construct absolute paths
    foreach ($paths as $key => $path) {
        $absolute_path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
        
        // Check if file exists
        if(file_exists($absolute_path)) {
            // Add to profilelinks array
            $globallinks[$key] = $absolute_path;
        } else {
            // Handle missing file error
            echo "Error: File not found for {$key}. Check the path: {$absolute_path}<br>";
        }
    }
} else {
    // Handle missing DOCUMENT_ROOT error
    echo "Error: \$_SERVER['DOCUMENT_ROOT'] is not set or empty. Please set it correctly.";
}

/*
===========================
Login Variables defined here.
===========================
*/

// Check if $_SERVER['DOCUMENT_ROOT'] is set and not empty
if(isset($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['DOCUMENT_ROOT'])) {
    // Define array to store profile links
    $profilelinks = array();
    
    // Define paths relative to the document root
    $paths = array(
        "process" => "projects/Homepage/includes/pages/login/process_login.php"
    );
    
    // Loop through paths and construct absolute paths
    foreach ($paths as $key => $path) {
        $absolute_path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
        
        // Check if file exists
        if(file_exists($absolute_path)) {
            // Add to profilelinks array
            $loginlinks[$key] = $absolute_path;
        } else {
            // Handle missing file error
            echo "Error: File not found for {$key}. Check the path: {$absolute_path}<br>";
        }
    }
} else {
    // Handle missing DOCUMENT_ROOT error
    echo "Error: \$_SERVER['DOCUMENT_ROOT'] is not set or empty. Please set it correctly.";
}

/*
===========================
Profile Variables defined here.
===========================
*/

// Check if $_SERVER['DOCUMENT_ROOT'] is set and not empty
if(isset($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['DOCUMENT_ROOT'])) {
    // Define array to store profile links
    $profilelinks = array();
    
    // Define paths relative to the document root
    $paths = array(
        "main" => "projects/Homepage/includes/pages/profile/main.php"
    );
    
    // Loop through paths and construct absolute paths
    foreach ($paths as $key => $path) {
        $absolute_path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
        
        // Check if file exists
        if(file_exists($absolute_path)) {
            // Add to profilelinks array
            $profilelinks[$key] = $absolute_path;
        } else {
            // Handle missing file error
            echo "Error: File not found for {$key}. Check the path: {$absolute_path}<br>";
        }
    }
} else {
    // Handle missing DOCUMENT_ROOT error
    echo "Error: \$_SERVER['DOCUMENT_ROOT'] is not set or empty. Please set it correctly.";
}
?>