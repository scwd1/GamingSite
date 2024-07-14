<?php
session_start();
include "functions.php";
$login_link = LoginCheck() ? $_SESSION['username'] : "Login";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaonashi Cove</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <div class="container">
        <h1>Kaonashi Cove</h1>
    </div>
</header>