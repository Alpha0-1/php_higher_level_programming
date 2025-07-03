<?php
/**
 * Get Star Wars movie title by episode ID
 * 
 * This script demonstrates API integration and JSON parsing
 * Usage: php 3-starwars_title.php <episode_id>
 * 
 * @author Alpha0-1
 */

/**
 * Get Star Wars movie title from SWAPI
 * 
 * @param int $episodeId The episode ID (1-9)
 * @return void
 */
function getStarWarsTitle($episodeId) {
    // Validate episode ID
    if (empty($episodeId) || !is_numeric($episodeId)) {
        echo "Usage: php 3-starwars_title.php <episode_id>\n";
        echo "Episode ID must be a number (1-9)\n";
        return;
    }
    
    $episodeId = intval($episodeId);
    
    if ($episodeId < 1 || $episodeId > 9) {
        echo "Error: Episode ID must be between 1 and 9.\n";
        return;
    }
    
    // SWAPI endpoint
    $url = "https://swapi.dev/api/films/$episodeId/";
    
    // Make API request
    $movieData = makeApiRequest($url);
    
    if ($movieData === false) {
        echo "Error: Could not fetch movie data.\n";
        return;
    }
    
    // Parse JSON response
    $movie = json_decode($movieData, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "Error: Invalid JSON response - " . json_last_error_msg() . "\n";
        return;
    }
    
    // Check if movie exists
    if (isset($movie['detail']) && $movie['detail'] === 'Not found') {
        echo "Error: Movie with ID $movieId not found.\n";
        return;
    }
    
    // Display movie information
    if (isset($movie['title'])) {
        echo "Movie: " . $movie['title'] . "\n";
        echo "Episode: " . $movie['episode_id'] . "\n";
        echo "Characters:\n";
    }
    
    // Get character data
    if (isset($movie['characters']) && is_array($movie['characters'])) {
        $characters = [];
        
        foreach ($movie['characters'] as $characterUrl) {
            $characterData = makeApiRequest($characterUrl);
            
            if ($characterData !== false) {
                $character = json_decode($characterData, true);
                
                if (isset($character['name'])) {
                    $characters[] = $character['name'];
                }
            }
        }
        
        // Sort characters alphabetically
        sort($characters);
        
        // Display characters
        foreach ($characters as $character) {
            echo $character . "\n";
        }
        
        echo "\nTotal characters: " . count($characters) . "\n";
    } else {
        echo "Error: No characters data found for movie.\n";
    }
}

/**
 * Make API request using cURL with caching
 * 
 * @param string $url The API endpoint URL
 * @return string|false The response data or false on failure
 */
function makeApiRequest($url) {
    static $cache = [];
    
    // Check cache first
    if (isset($cache[$url])) {
        return $cache[$url];
    }
    
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
        echo "cURL Error: " . curl_error($ch) . "\n";
        curl_close($ch);
        return false;
    }
    
    curl_close($ch);
    
    if ($httpCode !== 200) {
        echo "HTTP Error: $httpCode\n";
        return false;
    }
    
    // Cache the response
    $cache[$url] = $response;
    
    return $response;
}

/**
 * Get all Star Wars movies with their characters
 * 
 * @return void
 */
function getAllMoviesWithCharacters() {
    echo "=== All Star Wars Movies and Characters ===\n\n";
    
    for ($movieId = 1; $movieId <= 6; $movieId++) {
        echo "Movie ID: $movieId\n";
        listStarWarsCharacters($movieId);
        echo "\n" . str_repeat("=", 50) . "\n\n";
    }
}

// Get movie ID from command line arguments
$movieId = isset($argv[1]) ? $argv[1] : '';

// If no movie ID provided or special command, show options
if (empty($movieId)) {
    echo "Usage: php 100-starwars_characters.php <movie_id>\n";
    echo "Or use 'all' to see all movies: php 100-starwars_characters.php all\n";
} elseif ($movieId === 'all') {
    getAllMoviesWithCharacters();
} else {
    // Execute the function with provided movie ID
    listStarWarsCharacters($movieId);
}

?>
