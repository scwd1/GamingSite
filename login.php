<?php
include 'header.php';
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if there are any errors stored in the session
if(isset($_SESSION['error']) && !empty($_SESSION['error'])) {
    $error = $_SESSION['error'];
    // Clear the error message from the session
    unset($_SESSION['error']);
} else {
    $error = "";
}
?>
<div class="login-container">
    <h2>Login to Your Account</h2>
    <?php if(!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form class="login-form" action="loginpage.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
    <p>Don't have an account? <a href="register.php">Register</a></p>
</div>
<?php include 'footer.php'; ?>