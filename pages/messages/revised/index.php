<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messaging System</title>
    <link rel="stylesheet" href="fallout76.css">
    <script src="jquery.min.js"></script>
    <script src="messaging.js"></script>
    <style>
        /* Custom Fallout 76 style */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #000;
            color: #fff;
        }
        header {
            background-color: #0f0f0f;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        main {
            padding: 20px;
        }
        #message-list {
            max-height: 600px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #1f1f1f;
        }
        .message {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #292929;
        }
        .message .sender {
            font-weight: bold;
        }
        .message .timestamp {
            font-size: 0.8em;
            color: #999;
        }
        #loading {
            text-align: center;
            padding: 10px;
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <h1>Messaging System</h1>
    </header>

    <main>
        <div id="message-list"></div>
        <div id="loading">Loading...</div>
    </main>

    <footer>
        <p>&copy; 2024 Your Website Name</p>
    </footer>
</body>
</html>