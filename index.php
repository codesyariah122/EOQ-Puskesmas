<?php
// ob_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
// header("X-XSS-Protection: 1; mode=block");
// header("X-Content-Type-Options: nosniff");
// header("X-Frame-Options: SAMEORIGIN");
// header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
// header("Referrer-Policy: no-referrer");

require_once(dirname(__FILE__)) .'/public/app.php';