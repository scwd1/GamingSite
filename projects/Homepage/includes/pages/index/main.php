<link rel="stylesheet" href="layout/1column/style.css">
<main>
    <div class="container">
        <section>
            <h2>Section Title</h2>
            <p>Section content goes here...</p>
            <?php echo var_dump($_SESSION) ?>
            Your current admin level is <?= GetAdminLevel($_SESSION['user_id'], $conn) ?>
        </section>
    </div>
</main>