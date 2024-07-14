<nav>
    <a href="javascript:void(0);" class="icon" onclick="toggleMenu()">&#9776;</a>
    <div class="nav-links" id="myNavbar">
        <?= BuildNav($conn, $_SESSION['user_id']) ?>
    </div>
    <div class="login-button">
        <a href="
        <?php echo isset($_SESSION['username']) ? 'profile.php?id=' . GetUserID($conn, $_SESSION['username']) : 'login.php'; ?>
        ">
        <?php echo $login_link; ?>
        </a>
    </div>
</nav>