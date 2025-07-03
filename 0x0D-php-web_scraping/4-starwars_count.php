<?php
/**
 * Count character appearances in Star Wars movies
 * 
 * This script demonstrates advanced API usage and data processing
 * Usage: php 4-starwars_count.php <character_url>
 * 
 * @author Alpha0-1
 */

/**
 * Count character appearances in Star Wars movies
 * 
 * @param string $characterUrl The character URL from SWAPI
 * @return void
 */
function countCharacterAppearances($characterUrl) {
    // Validate character URL
    if (empty($characterUrl)) {
        echo "Usage: php 4-starwars_count.php <character_url>\n";
        echo "Example: php 4-starwars_count.php https://swapi.dev/api/people/1/\n";
        return;
    }
    
    if (!filter_var($characterUrl, FILTER_VALIDATE_URL)) {
        echo "Error: Invalid URL format.\n";
        return;
    }
    
    // Make API request for character data
    $characterData = makeApiRequest($characterUrl);
    
    if ($characterData === false) {
        echo "Error: Could not fetch character data.\n";
        return;
    }
    
    // Parse JSON response
    $character = json_decode($characterData, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "Error: Invalid JSON response - " . json_last_error_msg() . "\n";
        return;
    }
    
    // Check if character exists
    if (isset($character['detail']) && $character['detail'] === 'Not found') {
        echo "Error: Character not found.\n";
        return;
    }
    
    // Count movies (films)
    if (isset($character['films']) && is_array($character['films'])) {
        $movieCount = count($character['films']);
        echo "$movieCount\n";
        
        // Additional information for learning
        if (isset($character['name'])) {
            echo "Character: " . $character['name'] . "\n";
        }
        
        // List movies for educational purposes
        echo "Movies:\n";
        foreach ($character['films'] as $filmUrl) {
            $movieData = makeApiRequest($filmUrl);
            if ($movieData !== false) {
                $movie = json_decode($movieData, true);
                if (isset($movie['title'])) {
                    echo "  - " . $movie['title'] . "\n";
                }
            }
        }
    } else {
        echo "Error: No films data found for character.\n";
    }
}

/**
 * Make API request using cURL with retry logic
 * 
 * @param string $url The API endpoint URL
 * @param int $maxRetries Maximum number of retry attempts
 * @return string|false The response data or false on failure
 */
function makeApiRequest($url, $maxRetries = 3) {
    $attempt = 0;
    
    while ($attempt < $maxRetries) {
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; PHP Star Wars Client)',
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json'
            ]
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            echo "cURL Error (attempt " . ($attempt + 1) . "): " . curl_error($ch) . "\n";
            curl_close($ch);
            $attempt++;
            if ($attempt < $maxRetries) {
                sleep(1); // Wait before retry
            }
            continue;
        }
        
        curl_close($ch);
        
        if ($httpCode === 200) {
            return $response;
        }
        
        echo "HTTP Error (attempt " . ($attempt + 1) . "): $httpCode\n";
        $attempt++;
        if ($attempt < $maxRetries) {
            sleep(1); // Wait before retry
        }
    }
    
    return false;
}

// Get character URL from command line arguments
$characterUrl = isset($argv[1]) ? $argv[1] : '';

// Execute the function
countCharacterAppearances($characterUrl);

?>
