<?php
/**
 * Application Entry Point
 * This file serves as the front controller for all requests
 * It initializes the framework and routes requests to appropriate controllers
 */

// Define application constants
define('APP_ROOT', dirname(__DIR__));
define('APP_PATH', APP_ROOT . '/app');
define('CORE_PATH', APP_ROOT . '/core');
define('CONFIG_PATH', APP_ROOT . '/config');
define('PUBLIC_PATH', APP_ROOT . '/public');

// Start session
session_start();

// Autoloader function
spl_autoload_register(function ($class) {
    $paths = [
        CORE_PATH . '/' . $class . '.php',
        APP_PATH . '/Controllers/' . $class . '.php',
        APP_PATH . '/Models/' . $class . '.php',
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Load configuration
require_once CONFIG_PATH . '/app.php';
require_once CONFIG_PATH . '/database.php';

// Initialize database connection
$database = new Database();

// Initialize router and handle request
$router = new Router();
require_once CONFIG_PATH . '/routes.php';

// Handle the request
$request = new Request();
$response = new Response();

$router->handle($request, $response);

