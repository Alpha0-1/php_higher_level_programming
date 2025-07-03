<?php
/**
 * 5-delete_data.php - Deletes specific user records from the 'users' table.
 * Demonstrates safe deletion using prepared statements.
 */

require_once 'config/database.php';

try {
    $pdo = new PDO(
        "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset=utf8mb4",
        $dbConfig['username'],
        $dbConfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Delete a user by ID
    $userId = 3;

    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$userId]);

    echo "Deleted user with ID: {$userId}\n";
} catch (PDOException $e) {
    die("Delete failed: " . $e->getMessage());
}
