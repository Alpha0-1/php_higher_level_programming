<?php
/**
 * 0-connect.php - Establishes a connection to a MySQL database using PDO.
 * Demonstrates basic error handling for failed connections.
 */

// Include configuration
require_once 'config/database.php';

try {
    // Create a new PDO instance
    $pdo = new PDO(
        "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset=utf8mb4",
        $dbConfig['username'],
        $dbConfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    echo "Connected successfully to the database.\n";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
