<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';

$token = trim($_GET['token'] ?? '');
if ($token === '') {
    $_SESSION['verify_error'] = 'No verification token provided.';
    header('Location: ' . BASE_URL . '/login.php');
    exit;
}

$stmt = $conn->prepare('SELECT id FROM users WHERE verification_token = ? LIMIT 1');
if (!$stmt) {
    die('Prepare failed: ' . $conn->error);
}
$stmt->bind_param('s', $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $update = $conn->prepare('UPDATE users SET verified = 1, verification_token = NULL WHERE id = ?');
    $update->bind_param('i', $row['id']);
    if ($update->execute()) {
        header('Location: ' . BASE_URL . '/login.php?email=verified');
        exit;
    }
}

$_SESSION['verify_error'] = 'Invalid or expired verification token.';
header('Location: ' . BASE_URL . '/login.php');
exit;
