<?php
/**
 * CDN Integration in PHP
 * 
 * Techniques for integrating Content Delivery Networks with PHP applications.
 */

class CDNIntegration
{
    private $cdnUrl;
    private $localFallback;
    private $version;
    
    public function __construct(string $cdnUrl, string $localFallback = '', string $version = '')
    {
        $this->cdnUrl = rtrim($cdnUrl, '/');
        $this->localFallback = $localFallback;
        $this->version = $version;
    }
    
    /**
     * 1. Static Asset Loading with CDN Fallback
     */
    public function assetUrl(string $path): string
    {
        $versionedPath = $this->version ? "{$path}?v={$this->version}" : $path;
        
        if ($this->isCdnAvailable()) {
            return "{$this->cdnUrl}/{$versionedPath}";
        }
        
        return $this->localFallback ? "{$this->localFallback}/{$versionedPath}" : "/{$versionedPath}";
    }
    
    private function isCdnAvailable(): bool
    {
        // In production, you might actually check CDN availability
        return true; // Simplified for example
    }
    
    /**
     * 2. Dynamic Content Caching via CDN
     */
    public function cacheControlHeaders(int $maxAge = 3600, bool $public = true): void
    {
        header("Cache-Control: " . ($public ? 'public' : 'private') . ", max-age={$maxAge}");
        header("Expires: " . gmdate('D, d M Y H:i:s', time() + $maxAge) . ' GMT');
    }
    
    /**
     * 3. CDN for User Uploads
     */
    public function uploadToCdn(string $localPath, string $remotePath): bool
    {
        // Simulated upload process - in reality would use CDN API
        echo "Uploading {$localPath} to CDN as {$remotePath}\n";
        return true;
    }
    
    public function getCdnUrlForUpload(string $remotePath): string
    {
        return "{$this->cdnUrl}/uploads/{$remotePath}";
    }
    
    /**
     * 4. Cache Purging
     */
    public function purgeCdnCache(array $paths): bool
    {
        // Simulated purge - in reality would use CDN API
        echo "Purging CDN cache for: " . implode(', ', $paths) . "\n";
        return true;
    }
}

// Usage examples:
$cdn = new CDNIntegration(
    'https://cdn.example.com',
    '/local-assets',
    '1.0.0'
);

// Static assets
echo "<link rel='stylesheet' href='" . $cdn->assetUrl('css/app.css') . "'>\n";
echo "<script src='" . $cdn->assetUrl('js/app.js') . "'></script>\n";

// Dynamic content caching
$cdn->cacheControlHeaders(300); // Cache for 5 minutes

// User uploads
if ($cdn->uploadToCdn('/tmp/user-upload.jpg', 'users/123/profile.jpg')) {
    $imageUrl = $cdn->getCdnUrlForUpload('users/123/profile.jpg');
    echo "<img src='{$imageUrl}' alt='Profile photo'>\n";
}

/**
 * Key Takeaways:
 * 1. CDNs improve global content delivery speed
 * 2. Always implement fallback mechanisms
 * 3. Cache headers control how CDNs cache your content
 */
?>
