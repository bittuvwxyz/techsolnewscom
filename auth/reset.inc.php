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
// Prepare your email body messages
// $message = sprintf(
//     '<h2>Password Reset</h2><p>Click below:</p><p><a href="%s">%s</a></p>',
//     htmlspecialchars($link, ENT_QUOTES, 'UTF-8'),
//     htmlspecialchars($link, ENT_QUOTES, 'UTF-8')
// );
$message = sprintf('
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Password Reset</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f4;font-family:Arial,Helvetica,sans-serif;">
<table width="100%%" cellpadding="0" cellspacing="0" border="0" style="background:#f4f4f4;padding:40px 0;">
<tr>
<td align="center">
<table width="600" cellpadding="0" cellspacing="0" border="0"
style="background:#ffffff;border-radius:12px;overflow:hidden;
box-shadow:0 4px 15px rgba(0,0,0,.08);">
<tr>
<td align="center"
style="background:#111827;padding:35px;">
<img src="site.png"
width="60"
alt="Logo"
style="display:block;margin-bottom:15px;">

<h1 style="color:#ffffff;font-size:28px;margin:0;">
YourDomain
</h1>

</td>
</tr>

<tr>
<td style="padding:40px;">

<h2 style="margin:0 0 20px;color:#111827;font-size:26px;">
Password Reset
</h2>

<p style="margin:0 0 20px;color:#555;font-size:16px;line-height:26px;">
We received a request to reset your password.
If you made this request, click the button below.
</p>

<table cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
<td bgcolor="#22c55e" style="border-radius:8px;">
<a href="%s"
style="display:inline-block;padding:15px 35px;
color:#ffffff;
text-decoration:none;
font-size:16px;
font-weight:bold;">
Reset Password
</a>
</td>
</tr>
</table>

<p style="word-break:break-all;background:#f8f8f8;padding:12px;border-radius:6px;font-size:13px;color:#333;">%s</p>

<hr style="border:none;border-top:1px solid #eee;margin:35px 0;">

<p style="font-size:13px;color:#777;line-height:22px;">
This password reset link expires in <strong>30 minutes</strong>.
If you didn\'t request a password reset, you can safely ignore this email.
Your password will remain unchanged.
</p>


</td>
</tr>

<tr>
<td align="center"
style="padding:25px;
background:#f9f9f9;
color:#999;
font-size:12px;">

© %d YourDomain. All rights reserved.

</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>',
htmlspecialchars($link, ENT_QUOTES, 'UTF-8'),
htmlspecialchars($link, ENT_QUOTES, 'UTF-8'),
date('Y')
);

sendMail($email, 'Password reset', $message);

header('Location: ' . BASE_URL . '/index.php?reset=resetlinksent');
exit;
