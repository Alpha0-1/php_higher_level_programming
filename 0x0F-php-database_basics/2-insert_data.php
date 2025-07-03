<?php
/**
 * 2-insert_data.php - Inserts sample records into the 'users' table.
 * Demonstrates use of prepared statements to safely insert user data.
 */

require_once 'config/database.php';

try {
    $pdo = new PDO(
        "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset=utf8mb4",
        $dbConfig['username'],
        $dbConfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Prepare an INSERT statement
    $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");

    // Sample user data
    $users = [
        ['Alice Johnson', 'alice@example.com'],
        ['Bob Smith', 'bob@example.com'],
        ['Charlie Brown', 'charlie@example.com']
    ];

    foreach ($users as $user) {
        $stmt->execute($user);
    }

    echo count($users) . " users inserted successfully.\n";
} catch (PDOException $e) {
    die("Insert failed: " . $e->getMessage());
}
