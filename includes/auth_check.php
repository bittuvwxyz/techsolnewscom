<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: ' . (strpos($_SERVER['REQUEST_URI'], '/auth/') !== false ? '../login.php' : 'login.php'));
    exit;
}
?>