<?php
/**
 * Load environment variables from .env file
 */
function loadEnv($path) {
    if (!file_exists($path)) {
        throw new Exception('.env file not found');
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        // Parse KEY=VALUE
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        
        // Remove quotes if present
        $value = trim($value, '"\'');
        
        // Set as environment variable
        putenv("$key=$value");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

/**
 * Get required environment variable or throw exception
 */
function requireEnv(string $key): string {
    $value = getenv($key);
    if ($value === false) {
        throw new RuntimeException("Missing env variable: {$key}");
    }
    return $value;
}

// Load .env file
loadEnv(__DIR__ . '/.env');

// Application configuration
define('APP_ENV', requireEnv('APP_ENV'));

// Database configuration
define('DB_HOST', requireEnv('DB_HOST'));
define('DB_USERNAME', requireEnv('DB_USERNAME'));
define('DB_PASSWORD', requireEnv('DB_PASSWORD'));
define('DB_NAME', requireEnv('DB_NAME'));

// Assets configuration
define('ASSETS_BASE_URL', requireEnv('ASSETS_BASE_URL'));

// CORS configuration
define('ALLOWED_ORIGIN', requireEnv('ALLOWED_ORIGIN'));
