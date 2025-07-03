<?php
/**
 * Advanced cURL web scraper with multiple features
 * 
 * This script demonstrates advanced cURL techniques for web scraping
 * Usage: php 102-curl_scraper.php <url> [options]
 * 
 * @author Alpha0-1
 */

/**
 * Advanced web scraper class
 */
class AdvancedWebScraper {
    private $userAgent;
    private $timeout;
    private $followRedirects;
    private $maxRedirects;
    private $cookies;
    private $headers;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36';
        $this->timeout = 30;
        $this->followRedirects = true;
        $this->maxRedirects = 5;
        $this->cookies = [];
        $this->headers = [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Language: en-US,en;q=0.5',
            'Accept-Encoding: gzip, deflate',
            'Connection: keep-alive',
            'Upgrade-Insecure-Requests: 1'
        ];
    }
    
    /**
     * Set custom user agent
     * 
     * @param string $userAgent The user agent string
     */
    public function setUserAgent($userAgent) {
        $this->userAgent = $userAgent;
    }
    
    /**
     * Set timeout
     * 
     * @param int $timeout Timeout in seconds
     */
    public function setTimeout($timeout) {
        $this->timeout = $timeout;
    }
    
    /**
     * Add custom header
     * 
     * @param string $header The header to add
     */
    public function addHeader($header) {
        $this->headers[] = $header;
    }
    
    /**
     * Scrape URL with advanced options
     * 
     * @param string $url The URL to scrape
     * @param array $options Additional options
     * @return array Response data and metadata
     */
    public function scrape($url, $options = []) {
        // Validate URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return [
                'success' => false,
                'error' => 'Invalid URL format'
            ];
        }
        
        $ch = curl_init();
        
        // Basic cURL options
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => $this->followRedirects,
            CURLOPT_MAXREDIRS => $this->maxRedirects,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_USERAGENT => $this->userAgent,
            CURLOPT_HTTPHEADER => $this->headers,
            CURLOPT_ENCODING => '', // Enable all supported encodings
            CURLOPT_SSL_VERIFYPEER => false, // For development only
            CURLOPT_SSL_VERIFYHOST => false, // For development only
            CURLOPT_HEADER => false,
            CURLOPT_NOBODY => false
        ]);
        
        // Add cookies if available
        if (!empty($this->cookies)) {
            curl_setopt($ch, CURLOPT_COOKIE, $this->formatCookies());
        }
        
        // Handle POST requests
        if (isset($options['post_data'])) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $options['post_data']);
        }
        
        // Handle custom method
        if (isset($options['method'])) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $options['method']);
        }
        
        // Execute request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $info = curl_getinfo($ch);
        
        // Check for errors
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            
            return [
                'success' => false,
                'error' => $error
            ];
        }
        
        curl_close($ch);
        
        return [
            'success' => true,
            'data' => $response,
            'http_code' => $httpCode,
            'info' => $info,
            'url' => $url,
            'final_url' => $info['url']
        ];
    }
    
    /**
     * Format cookies for cURL
     * 
     * @return string Formatted cookie string
     */
    private function formatCookies() {
        $cookieString = '';
        foreach ($this->cookies as $name => $value) {
            $cookieString .= "$name=$value; ";
        }
        return rtrim($cookieString, '; ');
    }
    
    /**
     * Add cookie
     * 
     * @param string $name Cookie name
     * @param string $value Cookie value
     */
    public function addCookie($name, $value) {
        $this->cookies[$name] = $value;
    }
    
    /**
     * Scrape multiple URLs concurrently
     * 
     * @param array $urls Array of URLs to scrape
     * @return array Array of responses
     */
    public function scrapeMultiple($urls) {
        $multiHandle = curl_multi_init();
        $curlHandles = [];
        
        // Initialize cURL handles
        foreach ($urls as $index => $url) {
            $ch = curl_init();
            
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => $this->followRedirects,
                CURLOPT_MAXREDIRS => $this->maxRedirects,
                CURLOPT_TIMEOUT => $this->timeout,
                CURLOPT_USERAGENT => $this->userAgent,
                CURLOPT_HTTPHEADER => $this->headers,
                CURLOPT_ENCODING => '',
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            ]);
            
            curl_multi_add_handle($multiHandle, $ch);
            $curlHandles[$index] = $ch;
        }
        
        // Execute all requests
        $running = null;
        do {
            curl_multi_exec($multiHandle, $running);
            curl_multi_select($multiHandle);
        } while ($running > 0);
        
        // Collect results
        $results = [];
        foreach ($curlHandles as $index => $ch) {
            $response = curl_multi_getcontent($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $info = curl_getinfo($ch);
            
            $results[$index] = [
                'success' => !curl_errno($ch),
                'data' => $response,
                'http_code' => $httpCode,
                'info' => $info,
                'url' => $urls[$index],
                'error' => curl_errno($ch) ? curl_error($ch) : null
            ];
            
            curl_multi_remove_handle($multiHandle, $ch);
            curl_close($ch);
        }
        
        curl_multi_close($multiHandle);
        
        return $results;
    }
}

/**
 * Scrape URL and display results
 * 
 * @param string $url The URL to scrape
 * @param array $options Scraping options
 * @return void
 */
function scrapeUrl($url, $options = []) {
    $scraper = new AdvancedWebScraper();
    
    // Configure scraper based on options
    if (isset($options['timeout'])) {
        $scraper->setTimeout($options['timeout']);
    }
    
    if (isset($options['user_agent'])) {
        $scraper->setUserAgent($options['user_agent']);
    }
    
    if (isset($options['cookies'])) {
        foreach ($options['cookies'] as $name => $value) {
            $scraper->addCookie($name, $value);
        }
    }
    
    // Perform scraping
    $result = $scraper->scrape($url, $options);
    
    if (!$result['success']) {
        echo "Error: " . $result['error'] . "\n";
        return;
    }
    
    // Display results
    echo "=== Scraping Results ===\n";
    echo "URL: " . $result['url'] . "\n";
    echo "Final URL: " . $result['final_url'] . "\n";
    echo "HTTP Code: " . $result['http_code'] . "\n";
    echo "Content Length: " . strlen($result['data']) . " bytes\n";
    echo "Content Type: " . $result['info']['content_type'] . "\n";
    echo "Total Time: " . $result['info']['total_time'] . " seconds\n";
    echo "\n";
    
    // Display content preview
    echo "=== Content Preview (first 500 characters) ===\n";
    echo substr($result['data'], 0, 500) . "\n";
    
    if (strlen($result['data']) > 500) {
        echo "... (truncated)\n";
    }
}

/**
 * Demonstrate multiple URL scraping
 * 
 * @return void
 */
function demonstrateMultipleScraping() {
    echo "=== Multiple URL Scraping Demo ===\n\n";
    
    $urls = [
        'https://httpbin.org/status/200',
        'https://httpbin.org/json',
        'https://httpbin.org/user-agent',
        'https://httpbin.org/headers'
    ];
    
    $scraper = new AdvancedWebScraper();
    $results = $scraper->scrapeMultiple($urls);
    
    foreach ($results as $index => $result) {
        echo "URL " . ($index + 1) . ": " . $result['url'] . "\n";
        echo "Status: " . ($result['success'] ? 'Success' : 'Failed') . "\n";
        echo "HTTP Code: " . $result['http_code'] . "\n";
        echo "Content Length: " . strlen($result['data']) . " bytes\n";
        echo "\n";
    }
}

/**
 * Parse command line arguments
 * 
 * @param array $argv Command line arguments
 * @return array Parsed options
 */
function parseArguments($argv) {
    $options = [];
    
    for ($i = 2; $i < count($argv); $i++) {
        $arg = $argv[$i];
        
        if (strpos($arg, '--') === 0) {
            $parts = explode('=', substr($arg, 2), 2);
            $key = $parts[0];
            $value = isset($parts[1]) ? $parts[1] : true;
            
            // Handle special options
            switch ($key) {
                case 'timeout':
                    $options['timeout'] = intval($value);
                    break;
                case 'user-agent':
                    $options['user_agent'] = $value;
                    break;
                case 'method':
                    $options['method'] = strtoupper($value);
                    break;
                case 'post-data':
                    $options['post_data'] = $value;
                    break;
                default:
                    $options[$key] = $value;
            }
        }
    }
    
    return $options;
}

// Main execution
if (isset($argv[1])) {
    $url = $argv[1];
    
    if ($url === 'demo') {
        demonstrateMultipleScraping();
    } else {
        $options = parseArguments($argv);
        scrapeUrl($url, $options);
    }
} else {
    echo "Usage: php 102-curl_scraper.php <url> [options]\n";
    echo "Options:\n";
    echo "  --timeout=30         Set timeout in seconds\n";
    echo "  --user-agent=agent   Set custom user agent\n";
    echo "  --method=POST        Set HTTP method\n";
    echo "  --post-data=data     Set POST data\n";
    echo "\n";
    echo "Examples:\n";
    echo "  php 102-curl_scraper.php https://httpbin.org/json\n";
    echo "  php 102-curl_scraper.php https://httpbin.org/post --method=POST --post-data='key=value'\n";
    echo "  php 102-curl_scraper.php demo\n";
}

?>
