<?php
session_start();

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/mail.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/register.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $email === '' || $password === '') {
    die('All fields are required');
}

if (mb_strlen($username) < 3) {
    die('Username must be at least 3 characters');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Invalid email format');
}

if (strlen($password) < 6) {
    die('Password must be at least 6 characters');
}

$stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
if (!$stmt) {
    die('Prepare failed: ' . $conn->error);
}
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die('Email already registered');
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$token = bin2hex(random_bytes(32));

$stmt = $conn->prepare('INSERT INTO users (username, email, password, verification_token) VALUES (?, ?, ?, ?)');
if (!$stmt) {
    die('Insert prepare failed: ' . $conn->error);
}
$stmt->bind_param('ssss', $username, $email, $hashedPassword, $token);
if (!$stmt->execute()) {
    die('Insert failed: ' . $stmt->error);
}

$link = BASE_URL . '/auth/verify.php?token=' . urlencode($token);
$message = sprintf(
    '<h2>Email Verification</h2><p>Click below to verify your email:</p><p><a href="%s">Verify Email</a></p><p>Or copy this link:</p><p>%s</p>',
    htmlspecialchars($link, ENT_QUOTES, 'UTF-8'),
    htmlspecialchars($link, ENT_QUOTES, 'UTF-8')
);
$mailStatus = sendMail($email, 'Verify your email', $message);

$_SESSION['verify_alert'] = $mailStatus === true
    ? 'Please verify your email.'
    : 'Registration was successful, but the verification email could not be sent.';

header('Location: ' . BASE_URL . '/login.php?register=success' . ($mailStatus === true ? '&verify=emailsent' : ''));
exit;
