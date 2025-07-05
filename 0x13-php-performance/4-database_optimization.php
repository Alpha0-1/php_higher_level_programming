<?php
/**
 * Database Optimization in PHP
 * 
 * Techniques to optimize database interactions and queries.
 */

class DatabaseOptimizer
{
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    /**
     * 1. Prepared statements and parameter binding
     */
    public function getUserWithPreparedStatement(int $userId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
    
    /**
     * 2. Batch processing for large datasets
     */
    public function batchInsertUsers(array $users): bool
    {
        $batchSize = 100;
        $totalUsers = count($users);
        $processed = 0;
        
        $this->pdo->beginTransaction();
        
        try {
            $stmt = $this->pdo->prepare(
                "INSERT INTO users (name, email, created_at) VALUES (?, ?, NOW())"
            );
            
            foreach ($users as $user) {
                $stmt->execute([$user['name'], $user['email']]);
                $processed++;
                
                // Commit in batches to avoid large transactions
                if ($processed % $batchSize === 0 || $processed === $totalUsers) {
                    $this->pdo->commit();
                    if ($processed < $totalUsers) {
                        $this->pdo->beginTransaction();
                    }
                }
            }
            
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Batch insert failed: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * 3. Index optimization example
     */
    public function getUsersByEmail(string $email): array
    {
        // Ensure email column has an index in the database
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * 4. Query optimization with EXPLAIN
     */
    public function analyzeQuery(string $query): array
    {
        $stmt = $this->pdo->prepare("EXPLAIN " . $query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * 5. Connection pooling (implementation depends on your setup)
     */
    public static function getConnectionWithPooling(): PDO
    {
        static $pool = null;
        
        if ($pool === null) {
            $pool = new PDO(
                'mysql:host=localhost;dbname=test',
                'username',
                'password',
                [
                    PDO::ATTR_PERSISTENT => true, // Persistent connection
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
        }
        
        return $pool;
    }
}

/**
 * Key Takeaways:
 * 1. Always use prepared statements to prevent SQL injection
 * 2. Batch operations reduce database roundtrips
 * 3. Proper indexing is crucial for query performance
 */
?>
