<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/mail.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /contact.php');
    exit;
}

// Get form data
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

// Validation
$errors = [];

// Name
if ($name === '') {
    $errors[] = "Name is required.";
} elseif (mb_strlen($name) > 100) {
    $errors[] = "Name must not exceed 100 characters.";
}

// Email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
}

// Message
if ($message === '') {
    $errors[] = "Message is required.";
} elseif (mb_strlen($message) < 10) {
    $errors[] = "Message must be at least 10 characters.";
}

// Stop if validation fails
if (!empty($errors)) {
    $_SESSION['contact_error'] = implode('<br>', $errors);
    header('Location: /contact.php');
    exit;
}

// Prevent spam (max 5 messages every 5 minutes per IP)
$ip = $_SERVER['REMOTE_ADDR'] ?? '';

$stmt = $conn->prepare("SELECT COUNT(*) FROM contact_messages WHERE ip_address = ? AND created_at >= (NOW() - INTERVAL 5 MINUTE)");
if ($stmt === false) {
    throw new RuntimeException('Unable to prepare spam check query.');
}

$stmt->bind_param('s', $ip);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ((int) $count >= 5) {
    $_SESSION['contact_error'] = "Too many messages sent. Please try again later.";
    header('Location: /contact.php');
    exit;
}

// Save message
$stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)");
if ($stmt === false) {
    throw new RuntimeException('Unable to prepare contact message insert query.');
}

$agent = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500);
$emailLower = strtolower($email);

$stmt->bind_param('sssss', $name, $emailLower, $message, $ip, $agent);
$stmt->execute();
$stmt->close();

$messageBody = sprintf(
    'Name: %s <br> Email: (%s)<br> Message: %s',
    htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
    htmlspecialchars($email, ENT_QUOTES, 'UTF-8'),
    nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'))
);

$recipientEmail = defined('CONTACT_EMAIL') ? CONTACT_EMAIL : MAIL_FROM_EMAIL;
$senderCopyBody = sprintf(
    'Hello %s,<br><br>Thank you for contacting TechSolNews.com. We have received your message and will get back to you soon.<br><br>Your message:<br>%s',
    htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
    nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'))
);

$adminMailSent = sendMail($recipientEmail, 'New Contact Form Submission', $messageBody);
$senderMailSent = sendMail($email, 'We received your message', $senderCopyBody);

if ($adminMailSent && $senderMailSent) {
    $_SESSION['contact_success'] = 'Your message has been sent successfully.';
} elseif ($adminMailSent) {
    $_SESSION['contact_success'] = 'Your message was received. We sent the notification to our team.';
} else {
    $_SESSION['contact_error'] = 'Your message was saved, but the email could not be sent at this time.';
}

header('Location: /contact.php');
exit;