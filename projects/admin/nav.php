<nav>
    <a href="javascript:void(0);" class="icon" onclick="toggleMenu()">&#9776;</a>
    <div class="nav-links" id="myNavbar">
        <a href="/">Home</a>
        <a href="#">Forum</a>
        <a href="#">Events</a>
        <a href="#">Store</a>
        <a href="#">Quests</a>
        <a href="#">Social</a>
        <a href="#">Options</a>
    </div>
    <div class="login-button">
        <a href="
        <?php echo isset($_SESSION['username']) ? 'testing.php/?id=' . GetUserID($conn, $_SESSION['username']) : 'login.php'; ?>
        ">
        <?php echo $login_link; ?>
        </a>
    </div>
</nav>