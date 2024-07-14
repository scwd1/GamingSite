<?php require 'header.php'; ?>
<head>
    <style>
        /* Reset default browser styles */
        body, div, h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, embed,
        figure, figcaption, footer, header, hgroup,
        menu, nav, output, ruby, section, summary,
        time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }
        
        .tiles-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .tile {
            background-color: #000;
            background: linear-gradient(to bottom, rgba(100,100,100,1), rgba(125,125,125,0));
            padding: 20px;
            padding-right: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .tile:hover {
            transform: translateY(-5px);
        }
        
        h1 {
            margin: 0;
            font-size: 25px;
            padding-bottom: 20px;
            font-weight: bold;
        }
        
        .tile {
            position: relative;
        }
        
        .preview {
            position: relative;
            height: 200px;
        }
        
        .preview iframe {
            width: 100%;
            height: 100%;
            pointer-events: none;
            border-radius: 15px;
        }
        
        .zoom-content {
            zoom: 0.1;
        }
    </style>
</head>

<div class="tiles-container">
    <?php
    $tiles = [
        "Profile" => "profile.php",
        "Account Settings" => "settings.php",
        "Activity Feed" => "activity.php",
        "Recommendations" => "recommendations.php",
        "Notifications" => "notifications.php",
        "Support" => "support.php",
        "Favorites" => "favorites.php",
        "Analytics" => "analytics.php",
        "Community" => "community.php",
        "Integrations" => "integrations.php",
        "Customization" => "customization.php"
    ];

    foreach ($tiles as $title => $src) {
        echo "<div class='tile' id='$title'><h1>$title</h1><div class='preview'><iframe src='$src'><div class='zoom-content'></div></iframe></div></div>";
    }
    ?>
</div>
<?php require 'footer.php'; ?>