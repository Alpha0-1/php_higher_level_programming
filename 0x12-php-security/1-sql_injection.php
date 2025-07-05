<?php
/**
 * SQL Injection prevention using prepared statements
 */

// Database configuration
$dbHost = 'localhost';
$dbName = 'test_db';
$dbUser = 'db_user';
$dbPass = 'secure_password';

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Unsafe way (vulnerable to SQL injection)
    // $userId = $_GET['id']; // Could be "1; DROP TABLE users;--"
    // $stmt = $pdo->query("SELECT * FROM users WHERE id = $userId");
    
    // Safe way using prepared statements
    $userId = $_GET['id'] ?? 0;
    
    // Using named parameters
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([':id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Alternatively using positional parameters
    // $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    // $stmt->execute([$userId]);
    
    if ($user) {
        echo "User found: " . htmlspecialchars($user['username']);
    } else {
        echo "User not found";
    }
} catch (PDOException $e) {
    // Log the error (don't show to user in production)
    error_log("Database error: " . $e->getMessage());
    echo "An error occurred. Please try again later.";
}
?>
