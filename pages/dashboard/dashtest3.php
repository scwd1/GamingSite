<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        nav {
            background-color: #444;
            color: #fff;
            padding: 10px 20px;
        }
        .tiles-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .tile {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .tile:hover {
            transform: translateY(-5px);
        }
        h2 {
            margin-top: 0;
        }
        .tile {
            /* Other styles */
            position: relative; /* Necessary for positioning the iframe */
        }
        
        .preview {
            position: relative; /* Necessary for positioning the iframe */
            height: 200px; /* Adjust height as needed */
        }
        .preview iframe {
            width: 100%;
            height: 100%;
            border: none; /* Remove border */
            pointer-events: none; /* Make non-interactable */
        }
        .zoom-content {
            zoom: 0.8; /* Adjust the zoom level as needed */
        }
    </style>
</head>
<body>
    <header>
        <h1>User Dashboard</h1>
    </header>
    <nav>
        <ul class="tiles-container">
            <li class="tile" id="profile">
                <h2>Profile</h2>
                <div class="preview">
                    <iframe src="profile.php">
                        <div class="zoom-content"></div>
                    </iframe>
                </div>
            </li>
            <li class="tile" id="settings">
                <h2>Account Settings</h2>
                <div class="preview">
                    <iframe src="settings.php" frameborder="0" allowfullscreen></iframe>
                </div>
            </li>
            <!-- Add more tiles as needed -->
        </ul>
    </nav>
</body>
</html>