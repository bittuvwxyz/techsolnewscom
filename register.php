<?php
require_once 'config/db.php';
require_once 'config/config.php';
require_once 'includes/functions.php';
?>
<?php require_once 'includes/header.php'; ?>

<div class="container-form">
<div class="title-form">Register</div>
<p class="form-desc">Please fill in this form to create an account.</p>
  <form class="form-box" method="POST" action="/auth/register.php" onsubmit="return validateForm()">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="register" class="formbtn">Register</button>
  </form>
  <div class="formlink">Already have an account? <a href="login.php">Login</a></div>
</div>


<?php require_once 'includes/footer.php'; ?>