<?php
session_start();
require_once 'config/db.php';
require_once 'includes/functions.php';

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<?php require_once 'includes/header.php'; ?>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User', ENT_QUOTES, 'UTF-8'); ?></h2>

<a href="auth/logout.php">Logout</a>

<?php require_once 'includes/footer.php'; ?>