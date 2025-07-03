<?php
/**
 * seeds/PostsSeeder.php - Seeds the posts table with sample data.
 * Depends on users existing in the database.
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
    $pdo->exec("TRUNCATE TABLE posts");

    // Get user IDs
    $stmt = $pdo->query("SELECT id FROM users");
    $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (empty($userIds)) {
        die("[Seeder Error] No users found. Please seed users first.\n");
    }

    // Prepare insert statement
    $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");

    // Sample posts
    $posts = [
        ['Introduction to PHP', 'PHP is a server-side scripting language...'],
        ['MySQL Basics', 'MySQL is a popular open-source relational database...'],
        ['Web Development Tips', 'Here are some tips for building better websites...']
    ];

    foreach ($posts as $post) {
        $userId = $userIds[array_rand($userIds)]; // Random user
        $stmt->execute([$userId, $post[0], $post[1]]);
    }

    echo "[Seeder] Posts table seeded with " . count($posts) . " records.\n";
} catch (PDOException $e) {
    die("[Seeder Error] Failed to seed posts: " . $e->getMessage());
}
