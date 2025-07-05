<?php
/**
 * Performance Monitoring in PHP
 * 
 * Techniques for monitoring application performance and health.
 */

class PerformanceMonitor
{
    /**
     * 1. Request Timing
     */
    public static function trackRequestTime(): void
    {
        $startTime = $_SERVER['REQUEST_TIME_FLOAT'] ?? microtime(true);
        
        register_shutdown_function(function() use ($startTime) {
            $endTime = microtime(true);
            $duration = $endTime - $startTime;
            
            // Log or send to monitoring system
            error_log(sprintf(
                "Request to %s took %.3f seconds",
                $_SERVER['REQUEST_URI'] ?? '',
                $duration
            ));
            
            // Alert if too slow
            if ($duration > 2.0) { // 2 seconds threshold
                self::alertSlowRequest($_SERVER['REQUEST_URI'] ?? '', $duration);
            }
        });
    }
    
    private static function alertSlowRequest(string $endpoint, float $duration): void
    {
        // In reality, would send to monitoring system
        error_log("ALERT: Slow request to {$endpoint} took {$duration} seconds");
    }
    
    /**
     * 2. Memory Usage Monitoring
     */
    public static function logMemoryUsage(): void
    {
        $memoryUsed = memory_get_peak_usage(true) / 1024 / 1024; // MB
        $memoryLimit = ini_get('memory_limit');
        
        error_log(sprintf(
            "Memory usage: %.2fMB of %s",
            $memoryUsed,
            $memoryLimit
        ));
        
        // Warn if approaching limit
        if ($memoryUsed > self::convertToBytes($memoryLimit) * 0.8) {
            error_log("WARNING: Approaching memory limit");
        }
    }
    
    private static function convertToBytes(string $value): int
    {
        $unit = strtolower(substr($value, -1));
        $number = (int)substr($value, 0, -1);
        
        return match($unit) {
            'g' => $number * 1024 * 1024 * 1024,
            'm' => $number * 1024 * 1024,
            'k' => $number * 1024,
            default => (int)$value,
        };
    }
    
    /**
     * 3. Database Query Monitoring
     */
    public static function logDatabaseQueries(PDO $pdo): void
    {
        $pdo->setAttribute(PDO::ATTR_STATEMENT_CLASS, ['LoggedPDOStatement', [$pdo]]);
    }
    
    /**
     * 4. Error Tracking
     */
    public static function setupErrorHandling(): void
    {
        set_error_handler(function($errno, $errstr, $errfile, $errline) {
            error_log("PHP Error [$errno] $errstr in $errfile on line $errline");
            // Send to error tracking service
            return false; // Continue with normal error handling
        });
        
        set_exception_handler(function(Throwable $e) {
            error_log("Uncaught Exception: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());
            // Send to error tracking service
        });
    }
}

class LoggedPDOStatement extends PDOStatement
{
    private $pdo;
    
    protected function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function execute($params = null): bool
    {
        $start = microtime(true);
        $result = parent::execute($params);
        $time = microtime(true) - $start;
        
        $query = $this->queryString;
        if (strlen($query) > 100) {
            $query = substr($query, 0, 100) . '...';
        }
        
        error_log(sprintf("Query: %s (%.3f sec)", $query, $time));
        return $result;
    }
}

// Usage examples:
PerformanceMonitor::trackRequestTime();
PerformanceMonitor::setupErrorHandling();

// In your bootstrap code:
$pdo = new PDO('mysql:host=localhost;dbname=test', 'user', 'pass');
PerformanceMonitor::logDatabaseQueries($pdo);

// During request processing:
PerformanceMonitor::logMemoryUsage();

/**
 * Key Takeaways:
 * 1. Monitor key metrics: response time, memory, errors
 * 2. Set up alerts for abnormal conditions
 * 3. Centralize monitoring data for analysis
 */
?>
