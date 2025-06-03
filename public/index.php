<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (strpos($_SERVER['REQUEST_URI'], '/midtrans/callback') !== false) { // Gunakan strpos untuk fleksibilitas
    $logMessage = '[' . date('Y-m-d H:i:s') . '] RAW_CALLBACK_HIT_INDEX_PHP: ' . $_SERVER['REQUEST_URI'] . " - Method: " . $_SERVER['REQUEST_METHOD'] . "\n";
    // Path relatif dari public/index.php ke storage/logs/laravel.log
    // Sesuaikan kedalaman '../' jika struktur Anda berbeda atau ada symlink
    $logFilePath = __DIR__ . '/../storage/logs/laravel.log'; // __DIR__ adalah direktori dari file saat ini (public)
    file_put_contents($logFilePath, $logMessage, FILE_APPEND);
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
