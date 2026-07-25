<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/mail.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/reset.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
if ($email === '') {
    die('Email required');
}

$stmt = $conn->prepare('SELECT id, username FROM users WHERE email = ? LIMIT 1');
if (!$stmt) {
    die('Prepare failed: ' . $conn->error);
}
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('No user found');
}

$user = $result->fetch_assoc();
$token = bin2hex(random_bytes(32));
$stmt = $conn->prepare('UPDATE users SET reset_token = ? WHERE email = ?');
$stmt->bind_param('ss', $token, $email);
$stmt->execute();

$link = BASE_URL . '/auth/reset_password.php?token=' . urlencode($token);
$message = sprintf(
    '<h2>Password Reset</h2><p>Click below:</p><p><a href="%s">%s</a></p>',
    htmlspecialchars($link, ENT_QUOTES, 'UTF-8'),
    htmlspecialchars($link, ENT_QUOTES, 'UTF-8')
);
sendMail($email, 'Password reset', $message);

header('Location: ' . BASE_URL . '/index.php?reset=resetlinksent');
exit;
