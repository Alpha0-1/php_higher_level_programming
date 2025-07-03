<?php
/**
 * Get lorem ipsum text from loripsum.net API
 * 
 * This script demonstrates API integration for text generation
 * Usage: php 5-loripsum.php <url>
 * 
 * @author Alpha0-1
 */

/**
 * Get lorem ipsum text from specified URL
 * 
 * @param string $url The loripsum.net API URL
 * @return void
 */
function getLoremIpsum($url) {
    // Validate URL
    if (empty($url)) {
        echo "Usage: php 5-loripsum.php <url>\n";
        echo "Example: php 5-loripsum.php https://loripsum.net/api/3/short/plaintext\n";
        return;
    }
    
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        echo "Error: Invalid URL format.\n";
        return;
    }
    
    // Make API request
    $response = makeApiRequest($url);
    
    if ($response === false) {
        echo "Error: Could not fetch lorem ipsum text.\n";
        return;
    }
    
    // Display the response
    echo $response;
}

/**
 * Make API request using cURL
 * 
 * @param string $url The API endpoint URL
 * @return string|false The response data or false on failure
 */
function makeApiRequest($url) {
    $ch = curl_init();
    
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; PHP Lorem Ipsum Client)',
        CURLOPT_HTTPHEADER => [
            'Accept: text/plain, text/html, */*'
        ]
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch) . "\n";
        curl_close($ch);
        return false;
    }
    
    curl_close($ch);
    
    if ($httpCode !== 200) {
        echo "HTTP Error: $httpCode\n";
        return false;
    }
    
    return $response;
}

/**
 * Generate lorem ipsum URL with parameters
 * 
 * @param int $paragraphs Number of paragraphs
 * @param bool $short Use short paragraphs
 * @param bool $plaintext Return plain text instead of HTML
 * @return string The generated URL
 */
function generateLoremUrl($paragraphs = 3, $short = false, $plaintext = true) {
    $baseUrl = "https://loripsum.net/api";
    $params = [];
    
    if ($paragraphs > 0) {
        $params[] = $paragraphs;
    }
    
    if ($short) {
        $params[] = 'short';
    }
    
    if ($plaintext) {
        $params[] = 'plaintext';
    }
    
    return $baseUrl . '/' . implode('/', $params);
}

// Example usage function
function demonstrateLoremIpsum() {
    echo "=== Lorem Ipsum Generator Demo ===\n\n";
    
    // Example 1: Basic usage
    echo "1. Basic lorem ipsum (3 paragraphs):\n";
    $url1 = generateLoremUrl(3, false, true);
    echo "URL: $url1\n";
    getLoremIpsum($url1);
    echo "\n" . str_repeat("-", 50) . "\n\n";
    
    // Example 2: Short paragraphs
    echo "2. Short paragraphs (2 paragraphs):\n";
    $url2 = generateLoremUrl(2, true, true);
    echo "URL: $url2\n";
    getLoremIpsum($url2);
    echo "\n" . str_repeat("-", 50) . "\n\n";
    
    // Example 3: HTML format
    echo "3. HTML format (1 paragraph):\n";
    $url3 = generateLoremUrl(1, false, false);
    echo "URL: $url3\n";
    getLoremIpsum($url3);
    echo "\n";
}

// Get URL from command line arguments
$url = isset($argv[1]) ? $argv[1] : '';

// If no URL provided, show demo
if (empty($url)) {
    demonstrateLoremIpsum();
} else {
    // Execute the function with provided URL
    getLoremIpsum($url);
}

?>
