<?php
require_once __DIR__ . '/config.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, (int) DB_PORT);
    if ($conn === false) {
        throw new RuntimeException('Database connection failed: ' . mysqli_connect_error());
    }

    if (!mysqli_set_charset($conn, DB_CHARSET)) {
        throw new RuntimeException('Unable to set database charset.');
    }
} catch (Throwable $e) {
    error_log($e->getMessage());
    die('Database connection failed. Please check the configuration and try again.');
}
