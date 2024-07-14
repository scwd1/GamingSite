<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaonashi Cove</title>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Courier New', Courier, monospace;
            color: #333;
            margin: 0;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover, .dropdown:hover .dropbtn {
            background-color: #ddd;
            color: black;
        }
        .navbar a.icon {
            display: none;
        }
        @media screen and (max-width: 600px) {
            .navbar a:not(:first-child) {display: none;}
            .navbar a.icon {
                float: right;
                display: block;
            }
        }
        @media screen and (max-width: 600px) {
            .navbar.responsive {position: relative;}
            .navbar.responsive a.icon {
                position: absolute;
                right: 0;
                top: 0;
            }
            .navbar.responsive a {
                float: none;
                display: block;
                text-align: left;
            }
        }
        .content {
            padding: 20px;
        }
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="navbar" id="myNavbar">
    <a href="#">Home</a>
    <a href="#">Forum</a>
    <a href="#">Events</a>
    <a href="#">Gallery</a>
    <a href="#">Contact</a>
    <a href="javascript:void(0);" class="icon" onclick="toggleMenu()">
        &#9776;
    </a>
</div>

<div class="content">
    <h1>Welcome to Kaonashi Cove</h1>
    <p>Your one-stop community for post-apocalyptic gaming adventures.</p>
    <?php
    // Example PHP code
    echo "<p>Latest Community Update: " . date("F d, Y") . "</p>";
    ?>
</div>

<div class="footer">
    <p>Kaonashi Cove © <?php echo date("Y"); ?></p>
</div>

<script>
    function toggleMenu() {
        var x = document.getElementById("myNavbar");
        if (x.className === "navbar") {
            x.className += " responsive";
        } else {
            x.className = "navbar";
        }
    }
</script>

</body>
</html>