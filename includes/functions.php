<?php
// html speacial characters ko escape karne ke liye function
function escape($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
// generate random token for password reset
function generateToken() {
    return bin2hex(random_bytes(32));
}
// check if token is expired
function isTokenExpired($expiry) {
    return strtotime($expiry) < time();
}
