<?php
/**
 * Demonstrates Docker integration with PHP
 */

/**
 * Simple PHP application that connects to MySQL and Redis
 */

// Database configuration from environment variables
$dbHost = getenv('DB_HOST') ?: 'mysql';
$dbName = getenv('DB_NAME') ?: 'docker_demo';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') ?: 'password';

// Redis configuration
$redisHost = getenv('REDIS_HOST') ?: 'redis';

try {
    // MySQL connection
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create table if not exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS visitors (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ip_address VARCHAR(45),
        visit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Record visit
    $stmt = $pdo->prepare("INSERT INTO visitors (ip_address) VALUES (?)");
    $stmt->execute([$_SERVER['REMOTE_ADDR']]);
    
    // Get visit count
    $visitCount = $pdo->query("SELECT COUNT(*) FROM visitors")->fetchColumn();
    
    // Redis connection
    $redis = new Redis();
    $redis->connect($redisHost);
    
    // Increment Redis counter
    $redisCount = $redis->incr('page_hits');
    $redis->set('last_visit', date('Y-m-d H:i:s'));
    
    // Display information
    echo "<h1>Docker PHP Demo</h1>";
    echo "<p>MySQL Host: $dbHost</p>";
    echo "<p>Redis Host: $redisHost</p>";
    echo "<p>Total visits in database: $visitCount</p>";
    echo "<p>Page hits in Redis: $redisCount</p>";
    echo "<p>Last visit time: " . $redis->get('last_visit') . "</p>";
    
    // Display environment variables (for debugging)
    echo "<h2>Environment Variables</h2>";
    echo "<pre>" . print_r($_SERVER, true) . "</pre>";
    
} catch (PDOException $e) {
    echo "MySQL Error: " . $e->getMessage();
} catch (RedisException $e) {
    echo "Redis Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

/**
 * Sample Dockerfile content (commented as it's not executable PHP code)
 * 
 * # Dockerfile for PHP application
 * FROM php:8.2-apache
 * 
 * # Install extensions
 * RUN docker-php-ext-install pdo pdo_mysql
 * RUN pecl install redis && docker-php-ext-enable redis
 * 
 * # Copy application files
 * COPY . /var/www/html/
 * 
 * # Expose port
 * EXPOSE 80
 * 
 * # Environment variables
 * ENV DB_HOST=mysql
 * ENV DB_NAME=docker_demo
 * ENV DB_USER=root
 * ENV DB_PASS=password
 * ENV REDIS_HOST=redis
 * 
 * # Health check
 * HEALTHCHECK --interval=30s --timeout=3s \
 *   CMD curl -f http://localhost/ || exit 1
 */

/**
 * Sample docker-compose.yml content
 * 
 * version: '3.8'
 * 
 * services:
 *   app:
 *     build: .
 *     ports:
 *       - "8080:80"
 *     depends_on:
 *       - mysql
 *       - redis
 *     environment:
 *       - DB_HOST=mysql
 *       - DB_NAME=docker_demo
 *       - DB_USER=root
 *       - DB_PASS=password
 *       - REDIS_HOST=redis
 * 
 *   mysql:
 *     image: mysql:8.0
 *     environment:
 *       MYSQL_ROOT_PASSWORD: password
 *       MYSQL_DATABASE: docker_demo
 *     volumes:
 *       - mysql_data:/var/lib/mysql
 * 
 *   redis:
 *     image: redis:alpine
 * 
 * volumes:
 *   mysql_data:
 */

/**
 * Health check endpoint example
 */
if (isset($_GET['health'])) {
    header('Content-Type: application/json');
    
    $status = 'OK';
    $checks = [
        'mysql' => false,
        'redis' => false
    ];
    
    try {
        $pdo->query('SELECT 1');
        $checks['mysql'] = true;
    } catch (Exception $e) {
        $status = 'ERROR';
    }
    
    try {
        $checks['redis'] = $redis->ping();
    } catch (Exception $e) {
        $status = 'ERROR';
    }
    
    echo json_encode([
        'status' => $status,
        'checks' => $checks,
        'timestamp' => date('c')
    ]);
    exit;
}
