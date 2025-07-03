<?php
/**
 * 6-join_tables.php - Demonstrates INNER JOIN between users and posts tables.
 * Assumes posts table exists and has a foreign key to users.
 */

require_once 'config/database.php';

try {
    $pdo = new PDO(
        "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset=utf8mb4",
        $dbConfig['username'],
        $dbConfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $sql = "SELECT u.name, p.title, p.content 
            FROM users u
            INNER JOIN posts p ON u.id = p.user_id
            ORDER BY u.name";

    $stmt = $pdo->query($sql);

    echo "User Posts:\n";
    echo "------------------------------\n";
    echo sprintf("%-20s %-30s\n", "Author", "Post Title");
    echo "------------------------------\n";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo sprintf(
            "%-20s %-30s\n",
            $row['name'],
            $row['title']
        );
    }
} catch (PDOException $e) {
    die("Join failed: " . $e->getMessage());
}
