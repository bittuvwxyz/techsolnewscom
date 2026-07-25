<!-- Form for new password field -->
<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
?>
<?php require_once '../includes/header.php'; ?>
<?php
$token = trim($_GET['token'] ?? '');
if ($token === '') {
    header('Location: ' . BASE_URL . '/login.php?reset=invalidtoken');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    if (strlen($password) < 6) {
        die('Password must be at least 6 characters');
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare('SELECT id FROM users WHERE reset_token = ? LIMIT 1');
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die('Invalid token');
    }

    $row = $result->fetch_assoc();
    $update = $conn->prepare('UPDATE users SET password = ?, reset_token = NULL WHERE id = ?');
    $update->bind_param('si', $hashed, $row['id']);
    $update->execute();

    header('Location: ' . BASE_URL . '/login.php?reset=success');
    exit;
}
?>

<div class="container-form">
<div class="title-form">Reset Password</div>
<p class="form-desc">Please enter your new password.</p>
  <form class="form-box" method="POST" action="../auth/reset_password.php?token=<?php echo htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>" onsubmit="return validateForm()">
    <input type="password" name="password" placeholder="New Password" required>
    <button type="submit" name="reset_password" class="formbtn">Update Password</button>
  </form>
</div>


<?php require_once '../includes/footer.php'; ?>
