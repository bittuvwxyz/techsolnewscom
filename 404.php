<?php
http_response_code(404);
require_once __DIR__ . '../config/db.php';
require_once __DIR__ . '../config/config.php';
require_once __DIR__ . '../includes/functions.php';
require_once __DIR__ . '../includes/header.php';
?>

<h1>404 - Page Not Found</h1>
<p>Sorry, the page you are looking for does not exist. Please check the URL or return to the <a href="/">homepage</a>.</p>  

<?php
require_once __DIR__ . '../includes/footer.php';
?>