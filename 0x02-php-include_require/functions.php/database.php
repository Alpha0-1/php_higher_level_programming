<!-- includes/database.php -->
<?php
/**
 * Database Connection
 * Establishes and manages database connections
 * @author Your Name
 * @license MIT
 */

require_once 'config.php';

try {
    $dsn = 'mysql:host=localhost;dbname=demo_db;charset=utf8mb4';
    $username = 'db_user';
    $password = 'db_password';
    
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo formatMessage("Database connection established successfully") . "\n";
} catch (PDOException $e) {
    die(formatMessage("Database connection failed: " . $e->getMessage()));
}
