<?php
/**
 * 3-select_data.php - Fetches and displays all records from the 'users' table.
 * Demonstrates how to retrieve and display query results.
 */

require_once 'config/database.php';

try {
    $pdo = new PDO(
        "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset=utf8mb4",
        $dbConfig['username'],
        $dbConfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $stmt = $pdo->query("SELECT id, name, email, created_at FROM users");

    echo "User List:\n";
    echo "---------------------------------------------\n";
    echo sprintf("%-5s %-20s %-25s %-20s\n", "ID", "Name", "Email", "Created At");
    echo "---------------------------------------------\n";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo sprintf(
            "%-5d %-20s %-25s %-20s\n",
            $row['id'],
            $row['name'],
            $row['email'],
            date('Y-m-d H:i', strtotime($row['created_at']))
        );
    }
} catch (PDOException $e) {
    die("Select failed: " . $e->getMessage());
}
