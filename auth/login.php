<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    die('All fields are required');
}

$stmt = $conn->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
if (!$stmt) {
    die('Prepare failed: ' . $conn->error);
}
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('User not found');
}

$user = $result->fetch_assoc();
if ((int) $user['verified'] !== 1) {
    die('Please verify your email first');
}

if (!password_verify($password, $user['password'])) {
    die('Wrong password');
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['is_logged_in'] = true;
session_regenerate_id(true);

header('Location: ' . BASE_URL . '/dashboard.php');
exit;
