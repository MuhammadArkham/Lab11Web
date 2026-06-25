<?php
// Router script for PHP built-in server - CORS proxy

// Handle OPTIONS preflight - return immediately with CORS headers
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    header('Access-Control-Max-Age: 86400');
    http_response_code(204);
    die();
}

// CORS headers for non-OPTIONS requests
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Access-Control-Max-Age: 86400');

// Let PHP built-in server handle static files
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . '/public' . $path;
if (is_file($file)) {
    return false;
}

// Route everything through CodeIgniter - change to public/ dir first
chdir(__DIR__ . '/public');
require __DIR__ . '/public/index.php';
