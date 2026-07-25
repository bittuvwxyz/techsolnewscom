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

<div class="title-form">Login</div>
  <p class="form-desc">Please enter your credentials to login.</p>
  <form class="form-box" method="POST" action="auth/login.php" onsubmit="return validateForm()">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login" class="formbtn">Login</button>
  </form>
  <div class="formlink"><a href="register.php">Register</a></div>
  <div class="formlink"><a href="reset.php">Forgot Password</a></div>

</div>

<?php
require_once 'includes/footer.php';

?>