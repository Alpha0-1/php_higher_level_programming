<?php
/**
 * Caching Strategies in PHP
 * 
 * Demonstrates various caching techniques to improve application performance.
 */

/**
 * 1. File-based Caching
 */
class FileCache
{
    private $cacheDir;
    
    public function __construct(string $cacheDir = 'cache')
    {
        $this->cacheDir = rtrim($cacheDir, '/') . '/';
        if (!file_exists($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }
    
    public function get(string $key)
    {
        $file = $this->cacheDir . md5($key);
        
        if (!file_exists($file)) {
            return null;
        }
        
        $data = file_get_contents($file);
        $expiresAt = substr($data, 0, 10);
        
        if (time() > $expiresAt) {
            unlink($file);
            return null;
        }
        
        return unserialize(substr($data, 10));
    }
    
    public function set(string $key, $value, int $ttl = 3600): bool
    {
        $file = $this->cacheDir . md5($key);
        $expiresAt = time() + $ttl;
        $data = $expiresAt . serialize($value);
        return file_put_contents($file, $data) !== false;
    }
}

// Usage example:
$cache = new FileCache();
$key = 'homepage_data';

if (!$data = $cache->get($key)) {
    // Expensive operation to generate data
    $data = ['products' => getFeaturedProducts(), 'news' => getLatestNews()];
    $cache->set($key, $data, 300); // Cache for 5 minutes
}

/**
 * 2. Memcached Integration
 */
if (class_exists('Memcached')) {
    $memcached = new Memcached();
    $memcached->addServer('localhost', 11211);
    
    $memcacheKey = 'homepage_memcache';
    
    if (!$data = $memcached->get($memcacheKey)) {
        $data = ['products' => getFeaturedProducts(), 'news' => getLatestNews()];
        $memcached->set($memcacheKey, $data, 300);
    }
}

/**
 * 3. OPcache for PHP scripts
 * 
 * OPcache should be enabled in php.ini for production environments:
 * zend_extension=opcache.so
 * opcache.enable=1
 * opcache.enable_cli=1
 * opcache.memory_consumption=128
 * opcache.interned_strings_buffer=8
 * opcache.max_accelerated_files=4000
 * opcache.revalidate_freq=60
 */

/**
 * 4. HTTP Caching Headers
 */
function sendCachedResponse(string $content, int $maxAge = 3600): void
{
    header("Cache-Control: public, max-age={$maxAge}");
    header("Expires: " . gmdate('D, d M Y H:i:s', time() + $maxAge) . ' GMT');
    header("Last-Modified: " . gmdate('D, d M Y H:i:s') . ' GMT');
    header("ETag: " . md5($content));
    echo $content;
}

/**
 * Key Takeaways:
 * 1. Use appropriate caching strategy based on your needs
 * 2. Consider cache invalidation strategies
 * 3. Cache at different levels: application, database, HTTP
 */
?>
