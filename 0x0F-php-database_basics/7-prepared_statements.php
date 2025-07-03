<?php
/**
 * 7-prepared_statements.php - Demonstrates parameterized queries to prevent SQL injection.
 * Shows both named and positional placeholders.
 */

require_once 'config/database.php';

try {
    $pdo = new PDO(
        "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset=utf8mb4",
        $dbConfig['username'],
        $dbConfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Positional placeholder example
    $stmt1 = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt1->execute([2]);
    $user = $stmt1->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "User found (Positional): " . $user['name'] . "\n";
    }

    // Named placeholder example
    $stmt2 = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt2->execute([':email' => 'newalice@example.com']);
    $user = $stmt2->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "User found (Named): " . $user['name'] . "\n";
    }
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
