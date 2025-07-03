<?php
/**
 * Get HTTP status code from a URL
 * 
 * This script demonstrates HTTP requests and status code checking
 * Usage: php 2-statuscode.php <url>
 * 
 * @author Alpha0-1
 */

/**
 * Get HTTP status code from a URL using cURL
 * 
 * @param string $url The URL to check
 * @return void
 */
function getStatusCode($url) {
    // Validate URL
    if (empty($url)) {
        echo "Usage: php 2-statuscode.php <url>\n";
        return;
    }
    
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        echo "Error: Invalid URL format.\n";
        return;
    }
    
    // Initialize cURL
    $ch = curl_init();
    
    // Set cURL options
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_NOBODY => true,  // HEAD request only
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 5,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; PHP Status Checker)',
        CURLOPT_SSL_VERIFYPEER => false, // For development only
    ]);
    
    // Execute request
    $response = curl_exec($ch);
    
    // Check for cURL errors
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch) . "\n";
        curl_close($ch);
        return;
    }
    
    // Get HTTP status code
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    
    curl_close($ch);
    
    // Display results
    echo "code: $statusCode\n";
    
    // Additional information for learning
    if ($url !== $finalUrl) {
        echo "Redirected to: $finalUrl\n";
    }
    
    // Explain status code categories
    explainStatusCode($statusCode);
}

/**
 * Explain HTTP status code categories
 * 
 * @param int $code The HTTP status code
 * @return void
 */
function explainStatusCode($code) {
    $explanations = [
        200 => "OK - Request successful",
        201 => "Created - Resource created successfully",
        204 => "No Content - Request successful, no content returned",
        301 => "Moved Permanently - Resource permanently moved",
        302 => "Found - Resource temporarily moved",
        400 => "Bad Request - Invalid request syntax",
        401 => "Unauthorized - Authentication required",
        403 => "Forbidden - Access denied",
        404 => "Not Found - Resource not found",
        500 => "Internal Server Error - Server error",
        503 => "Service Unavailable - Server temporarily unavailable"
    ];
    
    if (isset($explanations[$code])) {
        echo "Explanation: " . $explanations[$code] . "\n";
    } else {
        $category = floor($code / 100);
        switch ($category) {
            case 1:
                echo "Category: Informational response\n";
                break;
            case 2:
                echo "Category: Success\n";
                break;
            case 3:
                echo "Category: Redirection\n";
                break;
            case 4:
                echo "Category: Client error\n";
                break;
            case 5:
                echo "Category: Server error\n";
                break;
        }
    }
}

// Get URL from command line arguments
$url = isset($argv[1]) ? $argv[1] : '';

// Execute the function
getStatusCode($url);

?>
