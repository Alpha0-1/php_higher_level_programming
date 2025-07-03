<?php
/**
 * List Star Wars movies by character
 * 
 * This script demonstrates reverse API lookups and data correlation
 * Usage: php 101-starwars_movies.php <character_url>
 * 
 * @author Alpha0-1
 */

/**
 * List movies featuring a specific character
 * 
 * @param string $characterUrl The character URL from SWAPI
 * @return void
 */
function listMoviesByCharacter($characterUrl) {
    // Validate character URL
    if (empty($characterUrl)) {
        echo "Usage: php 101-starwars_movies.php <character_url>\n";
        echo "Example: php 101-starwars_movies.php https://swapi.dev/api/people/1/\n";
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
    
    // Display character information
    if (isset($character['name'])) {
        echo "Character: " . $character['name'] . "\n";
        echo "Movies:\n";
    }
    
    // Get movie data
    if (isset($character['films']) && is_array($character['films'])) {
        $movies = [];
        
        foreach ($character['films'] as $filmUrl) {
            $filmData = makeApiRequest($filmUrl);
            
            if ($filmData !== false) {
                $film = json_decode($filmData, true);
                
                if (isset($film['title']) && isset($film['episode_id'])) {
                    $movies[] = [
                        'title' => $film['title'],
                        'episode_id' => $film['episode_id'],
                        'release_date' => $film['release_date'] ?? 'Unknown'
                    ];
                }
            }
        }
        
        // Sort movies by episode ID
        usort($movies, function($a, $b) {
            return $a['episode_id'] - $b['episode_id'];
        });
        
        // Display movies
        foreach ($movies as $movie) {
            echo $movie['title'] . "\n";
        }
        
        echo "\nTotal movies: " . count($movies) . "\n";
        
        // Additional information for learning
        echo "\nDetailed information:\n";
        foreach ($movies as $movie) {
            echo "  Episode {$movie['episode_id']}: {$movie['title']} ({$movie['release_date']})\n";
        }
    } else {
        echo "Error: No films data found for character.\n";
    }
}

/**
 * Make API request using cURL with error handling
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
    
    return $response;
}

/**
 * Search for character by name
 * 
 * @param string $name The character name to search for
 * @return string|false The character URL or false if not found
 */
function searchCharacterByName($name) {
    $searchUrl = "https://swapi.dev/api/people/?search=" . urlencode($name);
    $searchData = makeApiRequest($searchUrl);
    
    if ($searchData === false) {
        return false;
    }
    
    $results = json_decode($searchData, true);
    
    if (isset($results['results']) && count($results['results']) > 0) {
        return $results['results'][0]['url'];
    }
    
    return false;
}

/**
 * Demonstrate popular characters and their movies
 * 
 * @return void
 */
function demonstratePopularCharacters() {
    echo "=== Popular Star Wars Characters and Their Movies ===\n\n";
    
    $popularCharacters = [
        'Luke Skywalker' => 'https://swapi.dev/api/people/1/',
        'Darth Vader' => 'https://swapi.dev/api/people/4/',
        'Leia Organa' => 'https://swapi.dev/api/people/5/',
        'Han Solo' => 'https://swapi.dev/api/people/14/',
        'Yoda' => 'https://swapi.dev/api/people/20/',
        'Obi-Wan Kenobi' => 'https://swapi.dev/api/people/10/'
    ];
    
    foreach ($popularCharacters as $name => $url) {
        echo "Character: $name\n";
        listMoviesByCharacter($url);
        echo "\n" . str_repeat("=", 50) . "\n\n";
    }
}

// Get character URL from command line arguments
$characterUrl = isset($argv[1]) ? $argv[1] : '';

// If no character URL provided or special command, show options
if (empty($characterUrl)) {
    echo "Usage: php 101-starwars_movies.php <character_url>\n";
    echo "Or use 'demo' to see popular characters: php 101-starwars_movies.php demo\n";
    echo "Or search by name: php 101-starwars_movies.php \"Luke Skywalker\"\n";
} elseif ($characterUrl === 'demo') {
    demonstratePopularCharacters();
} elseif (!filter_var($characterUrl, FILTER_VALIDATE_URL)) {
    // Try to search by name
    echo "Searching for character: $characterUrl\n";
    $foundUrl = searchCharacterByName($characterUrl);
    
    if ($foundUrl) {
        echo "Found character URL: $foundUrl\n\n";
        listMoviesByCharacter($foundUrl);
    } else {
        echo "Character not found. Please provide a valid SWAPI character URL.\n";
    }
} else {
    // Execute the function with provided character URL
    listMoviesByCharacter($characterUrl);
}

?>
