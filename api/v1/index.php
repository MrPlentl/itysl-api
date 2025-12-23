<?php

// Include configuration
require_once __DIR__ . '/../../config.php';

// Include helpers
require_once __DIR__ . '/helpers/Response.php';

// Include models
require_once __DIR__ . '/models/Database.php';
require_once __DIR__ . '/models/Quote.php';
require_once __DIR__ . '/models/Tag.php';

// Include controllers
require_once __DIR__ . '/controllers/QuotesController.php';
require_once __DIR__ . '/controllers/TagsController.php';

// Include Router
require_once __DIR__ . '/core/Router.php';

// Set CORS headers
header('Access-Control-Allow-Origin: ' . ALLOWED_ORIGIN);
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Accept, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Initialize router
$router = new Router();

// Load route files
require_once __DIR__ . '/routes/quotes.php';
require_once __DIR__ . '/routes/tags.php';

// Dispatch the request
try {
    $router->dispatch();
} catch (Exception $e) {
    Response::error($e->getMessage(), 500);
}
