<?php
require_once 'config/db.php';
require_once 'config/config.php';
require_once 'includes/functions.php';

$page = $_GET['page'] ?? 'index';

$allowed_pages = [
    'index',
    'post',
    'blog'
];
require_once 'includes/header.php';
?>
<div class="container-form">
<?php
session_start();
if(isset($_SESSION['verify_alert'])):
?>
<!-- Verification email sent. Please verify your email before login. -->
<div class="alert-danger"><?= $_SESSION['verify_alert']; ?></div>
<?php
unset($_SESSION['verify_alert']);
endif;
?>

<div class="title-text">Login</div>
  <p class="form-description">Please enter your credentials to login.</p>
  <form class="form-box" method="POST" action="auth/login.php" onsubmit="return validateForm()">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
  </form>
  <div class="link">Don't have an account? 
    <a href="register.php">Register</a>
  </div>

</div>

<?php
require_once 'includes/footer.php';

?>