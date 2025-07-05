<?php
/**
 * Database Class
 * Handles database connections and operations using PDO
 */
class Database
{
    private static $instance = null;
    private $pdo;
    private $config;
    
    /**
     * Constructor (private for singleton pattern)
     */
    private function __construct()
    {
        $this->config = require CONFIG_PATH . '/database.php';
        $this->connect();
    }
    
    /**
     * Get database instance (singleton)
     * @return PDO
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        
        return self::$instance->pdo;
    }
    
    /**
     * Connect to database
     */
    private function connect()
    {
        try {
            $dsn = "mysql:host={$this->config['host']};dbname={$this->config['database']};charset=utf8mb4";
            $this->pdo = new PDO($dsn, $this->config['username'], $this->config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }
    
    /**
     * Prevent cloning
     */
    private function __clone() {}
    
    /**
     * Prevent unserialization
     */
    private function __wakeup() {}
}
