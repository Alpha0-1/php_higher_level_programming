<?php
/**
 * 101-migration.php - Simple migration runner that applies migration scripts.
 * Simulates running migration files in order.
 */

require_once 'config/database.php';

$migrationsDir = __DIR__ . '/migrations/';

// Ensure migrations directory exists
if (!is_dir($migrationsDir)) {
    mkdir($migrationsDir, 0777, true);
    file_put_contents($migrationsDir . 'README.md', '# Migrations');
    echo "Created migrations directory.\n";
}

// Define migration files to run
$migrationFiles = [
    '001_create_users_table.php',
    '002_create_posts_table.php'
];

foreach ($migrationFiles as $filename) {
    $filePath = $migrationsDir . $filename;
    
    if (file_exists($filePath)) {
        require_once $filePath;
        echo "Executed migration: {$filename}\n";
    } else {
        echo "Migration file not found: {$filename}\n";
    }
}
