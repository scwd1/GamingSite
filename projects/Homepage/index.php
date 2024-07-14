<?php
session_start();
require("includes/db.php");
require("includes/head.php");
require("includes/nav.php");
?>
<link rel="stylesheet" href="layout/1column/style.css">
<main>
    <div class="container">
        <section>
            <h2>Section Title</h2>
            <p>Section content goes here...</p>
            <?php //echo var_dump($_SESSION) ?>
        </section>
    </div>
</main>
<?php
require("includes/foot.html");
?>