<?php
/**
 * 102-seeder.php - Seeds the database with initial test data.
 * Demonstrates loading seed files to populate tables.
 */

require_once 'config/database.php';

$seedsDir = __DIR__ . '/seeds/';

// Ensure seeds directory exists
if (!is_dir($seedsDir)) {
    mkdir($seedsDir, 0777, true);
    file_put_contents($seedsDir . 'README.md', '# Seeds');
    echo "Created seeds directory.\n";
}

// Define seed files to run
$seedFiles = [
    'UsersSeeder.php',
    'PostsSeeder.php'
];

foreach ($seedFiles as $filename) {
    $filePath = $seedsDir . $filename;
    
    if (file_exists($filePath)) {
        require_once $filePath;
        echo "Executed seeder: {$filename}\n";
    } else {
        echo "Seeder file not found: {$filename}\n";
    }
}
