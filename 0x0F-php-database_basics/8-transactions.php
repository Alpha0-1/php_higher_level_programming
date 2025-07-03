<?php
/**
 * 8-transactions.php - Demonstrates transaction handling with commit and rollback.
 * Ensures atomicity when inserting related records.
 */

require_once 'config/database.php';

try {
    $pdo = new PDO(
        "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset=utf8mb4",
        $dbConfig['username'],
        $dbConfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Begin transaction
    $pdo->beginTransaction();

    try {
        // Insert user
        $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->execute(['David Wilson', 'david@example.com']);
        $userId = $pdo->lastInsertId();

        // Insert post associated with user
        $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
        $stmt->execute([$userId, 'My First Post', 'This is the content of my first post']);

        // Commit transaction
        $pdo->commit();
        echo "Transaction committed successfully.\n";
    } catch (Exception $e) {
        // Rollback on failure
        $pdo->rollBack();
        echo "Transaction rolled back: " . $e->getMessage() . "\n";
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
