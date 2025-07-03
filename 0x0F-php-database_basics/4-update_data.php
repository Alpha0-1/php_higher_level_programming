<?php
/**
 * 4-update_data.php - Updates specific user records in the 'users' table.
 * Demonstrates updating records using prepared statements.
 */

require_once 'config/database.php';

try {
    $pdo = new PDO(
        "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset=utf8mb4",
        $dbConfig['username'],
        $dbConfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Update a user's email by ID
    $userId = 1;
    $newEmail = 'newalice@example.com';

    $stmt = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
    $stmt->execute([$newEmail, $userId]);

    echo "Updated user ID {$userId} with new email: {$newEmail}\n";
} catch (PDOException $e) {
    die("Update failed: " . $e->getMessage());
}
