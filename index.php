<?php

require_once 'config/db.php';
require_once 'includes/functions.php';

$page = $_GET['page'] ?? 'index';

$allowed_pages = [
    'index',
    'post',
    'blog'
];



require_once 'includes/header.php';
require_once 'includes/homelanding.php';
require_once 'includes/footer.php';

?>