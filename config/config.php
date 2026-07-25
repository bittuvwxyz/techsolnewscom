<?php
define('BASE_URL', 'http://localhost');
date_default_timezone_set('Asia/Kolkata');

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'website');
define('DB_PORT', '3306');
define('DB_CHARSET', 'utf8mb4');
define('SITE_NAME', 'Techsolnews.com');

define('MAIL_HOST', getenv('MAIL_HOST') ?: 'smtp.gmail.com');
define('MAIL_USERNAME', getenv('MAIL_USERNAME') ?: 'bittu32954@gmail.com');
define('MAIL_PASSWORD', getenv('MAIL_PASSWORD') ?: '');
define('MAIL_FROM_EMAIL', getenv('MAIL_FROM_EMAIL') ?: 'bittu32954@gmail.com');
define('MAIL_FROM_NAME', getenv('MAIL_FROM_NAME') ?: 'Bittu');
?>