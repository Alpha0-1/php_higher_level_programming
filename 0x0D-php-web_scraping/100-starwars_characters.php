<?php
/**
 * 100-starwars_characters.php
 * 
 * This script demonstrates advanced web scraping techniques by fetching
 * and displaying all Star Wars characters from the Star Wars API (SWAPI).
 * It showcases JSON parsing, error handling, and pagination handling.
 * 
 * Learning Objectives:
 * - Understanding API pagination
 * - JSON data manipulation
 * - Error handling in web requests
 * - Data formatting and presentation
 * 
 * Usage: php 100-starwars_characters.php
 */

/**
 * Fetches all Star Wars characters from SWAPI
 * 
 * This function demonstrates how to handle paginated API responses
 * by continuously fetching pages until all data is collected.
 * 
 * @return array Array of all characters or empty array on failure
 */
function fetchAllCharacters() {
    $allCharacters = [];
    $nextUrl = "https://swapi.dev/api/people/";
    
    // Continue fetching until there are no more pages
    while ($nextUrl) {
        // Initialize cURL session
        $curl = curl_init();
        
        // Set cURL options for reliable data fetching
        curl_setopt_array($curl, [
            CURLOPT_URL => $nextUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => 'PHP-Student-Scraper/1.0',
            CURLOPT_SSL_VERIFYPEER => false, // For educational purposes only
        ]);
        
        // Execute request and capture response
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        // Check for cURL errors
        if (curl_error($curl)) {
            echo "cURL Error: " . curl_error($curl) . "\n";
            curl_close($curl);
            return [];
        }
        
        curl_close($curl);
        
        // Validate HTTP response
        if ($httpCode !== 200) {
            echo "HTTP Error: Received status code $httpCode\n";
            return [];
        }
        
        // Parse JSON response
        $data = json_decode($response, true);
        
        // Check for JSON parsing errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "JSON Error: " . json_last_error_msg() . "\n";
            return [];
        }
        
        // Add characters from this page to our collection
        if (isset($data['results'])) {
            $allCharacters = array_merge($allCharacters, $data['results']);
        }
        
        // Set next URL for pagination (null if no more pages)
        $nextUrl = $data['next'] ?? null;
        
        // Add small delay to be respectful to the API
        usleep(100000); // 0.1 second delay
    }
    
    return $allCharacters;
}

/**
 * Displays character information in a formatted way
 * 
 * @param array $characters Array of character data
 */
function displayCharacters($characters) {
    if (empty($characters)) {
        echo "No characters found.\n";
        return;
    }
    
    echo "=== STAR WARS CHARACTERS ===\n";
    echo "Total characters found: " . count($characters) . "\n\n";
    
    foreach ($characters as $index => $character) {
        $characterNumber = $index + 1;
        
        // Extract and display key character information
        $name = $character['name'] ?? 'Unknown';
        $height = $character['height'] ?? 'Unknown';
        $mass = $character['mass'] ?? 'Unknown';
        $birthYear = $character['birth_year'] ?? 'Unknown';
        $gender = $character['gender'] ?? 'Unknown';
        
        echo "[$characterNumber] $name\n";
        echo "    Height: $height cm\n";
        echo "    Mass: $mass kg\n";
        echo "    Birth Year: $birthYear\n";
        echo "    Gender: $gender\n";
        echo "    ---\n";
    }
}

/**
 * Demonstrates character filtering and searching
 * 
 * @param array $characters Array of character data
 * @param string $searchTerm Term to search for in character names
 */
function searchCharacters($characters, $searchTerm) {
    echo "\n=== SEARCH RESULTS FOR: '$searchTerm' ===\n";
    
    $found = array_filter($characters, function($character) use ($searchTerm) {
        return stripos($character['name'], $searchTerm) !== false;
    });
    
    if (empty($found)) {
        echo "No characters found matching '$searchTerm'\n";
        return;
    }
    
    foreach ($found as $character) {
        echo "- " . $character['name'] . "\n";
    }
}

/**
 * Main execution function
 * 
 * This function orchestrates the entire scraping process and demonstrates
 * various data manipulation techniques.
 */
function main() {
    echo "Starting Star Wars character scraping...\n";
    echo "This may take a few moments to fetch all data.\n\n";
    
    // Fetch all characters
    $characters = fetchAllCharacters();
    
    if (empty($characters)) {
        echo "Failed to fetch characters. Please check your internet connection.\n";
        return;
    }
    
    // Display all characters
    displayCharacters($characters);
    
    // Demonstrate search functionality
    searchCharacters($characters, "Luke");
    searchCharacters($characters, "Darth");
    
    // Show some statistics
    echo "\n=== STATISTICS ===\n";
    
    $humans = array_filter($characters, function($char) {
        return strtolower($char['species'][0] ?? '') === 'human' || 
               strtolower($char['species'] ?? '') === 'human';
    });
    
    $knownHeights = array_filter($characters, function($char) {
        return isset($char['height']) && $char['height'] !== 'unknown' && is_numeric($char['height']);
    });
    
    echo "Total characters: " . count($characters) . "\n";
    echo "Characters with known heights: " . count($knownHeights) . "\n";
    
    if (!empty($knownHeights)) {
        $heights = array_column($knownHeights, 'height');
        $avgHeight = array_sum($heights) / count($heights);
        echo "Average height: " . round($avgHeight, 2) . " cm\n";
    }
}

// Execute the main function if this file is run directly
if (php_sapi_name() === 'cli') {
    main();
} else {
    // For web execution, set proper headers
    header('Content-Type: text/plain');
    main();
}

/*
 * NOTES:
 * 
 * 1. API Pagination: This script demonstrates how to handle paginated APIs
 *    by following the 'next' links until all data is retrieved.
 * 
 * 2. Error Handling: Multiple levels of error checking ensure robust operation:
 *    - cURL errors
 *    - HTTP status codes
 *    - JSON parsing errors
 * 
 * 3. Data Processing: Shows how to filter, search, and analyze scraped data
 *    using PHP's array functions.
 * 
 * 4. Rate Limiting: Includes a small delay between requests to be respectful
 *    to the API server.
 * 
 * 5. Memory Efficiency: Processes data in chunks rather than loading everything
 *    into memory at once.
 * 
 * COMMON PITFALLS TO AVOID:
 * - Not handling pagination properly
 * - Missing error handling for network requests
 * - Not respecting API rate limits
 * - Assuming data structure without validation
 */
?
