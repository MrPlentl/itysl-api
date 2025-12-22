<?php
declare(strict_types=1);

// Load your project config
require_once __DIR__ . '/config.php';

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/database/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'default',
        'default' => [
            'adapter' => 'mysql',
            'host' => DB_HOST,
            'name' => DB_NAME,
            'user' => DB_USERNAME,
            'pass' => DB_PASSWORD,
            'port' => 3306,
            'charset' => 'utf8mb4',
        ],
    ],
    'version_order' => 'creation'
];
