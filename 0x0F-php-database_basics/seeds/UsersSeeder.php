<?php
/**
 * seeds/UsersSeeder.php - Seeds the users table with sample data.
 */

use PDO;

require_once '../../config/database.php';

try {
    $pdo = new PDO(
        "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset=utf8mb4",
        $dbConfig['username'],
        $dbConfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Clear existing data
    $pdo->exec("TRUNCATE TABLE users");

    // Prepare insert statement
    $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");

    // Sample users
    $users = [
        ['John Doe', 'john@example.com'],
        ['Jane Smith', 'jane@example.com'],
        ['Mike Johnson', 'mike@example.com']
    ];

    foreach ($users as $user) {
        $stmt->execute($user);
    }

    echo "[Seeder] Users table seeded with " . count($users) . " records.\n";
} catch (PDOException $e) {
    die("[Seeder Error] Failed to seed users: " . $e->getMessage());
}
