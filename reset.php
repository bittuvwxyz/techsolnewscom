<?php
require_once 'config/db.php';
require_once 'config/config.php';
require_once 'includes/functions.php';
?>
<?php require_once 'includes/header.php'; ?>


<div class="container-form">
<div class="title-form">Reset Password</div>
<p class="form-desc">Please enter your email.</p>
  <form class="form-box" method="POST" action="/auth/reset.inc.php" onsubmit="return validateForm()">
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit" name="reset_password" class="formbtn">Reset Password</button>
  </form>
</div>

<?php require_once 'includes/footer.php'; ?>
