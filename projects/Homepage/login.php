<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . "/projects/Homepage/includes/linkdir.php");
require($globallinks['database']);
require($globallinks['header']);
require($globallinks['nav']);

// Check if user is already logged in
if(isset($_SESSION['user_id'])) {
    // Redirect the user to another page or display a message
    //header("Location: index.php");
    //exit; // Make sure to stop the script execution after redirection
}

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

?>
<link rel="stylesheet" href="layout/1column/style.css">
<main>
        <section>
            <div class="login-container">
                <h2>Login to your account!</h2>
                <form id="login-form" action="includes/pages/login/process_login.php" method="post">
                  
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="remember_me">Remember Me:</label>
                        <input type="checkbox" id="remember_me" name="remember_me">
                    </div>
                    <button type="submit">Login</button>
                    <div id="error-message"></div>
                </form>
            </div>
            <script src="/assets/js/login.js"></script>
        </section>
</main>
<?php
require($globallinks['footer']);
?>