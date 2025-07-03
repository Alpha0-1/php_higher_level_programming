<?php
/**
 * 100-orm_basic.php - Simple demonstration of a basic Object Relational Mapping (ORM).
 * Simulates ORM functionality without using any framework.
 */

require_once 'config/database.php';

class User {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function create(array $data) {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        return $stmt->execute([$data['name'], $data['email']]);
    }

    public function find(int $id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function all() {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

try {
    $pdo = new PDO(
        "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset=utf8mb4",
        $dbConfig['username'],
        $dbConfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $userModel = new User($pdo);

    // Create a user
    $userModel->create(['name' => 'Eve Adams', 'email' => 'eve@example.com']);
    
    // Get all users
    $users = $userModel->all();
    
    echo "All Users:\n";
    print_r($users);
} catch (PDOException $e) {
    die("ORM failed: " . $e->getMessage());
}
