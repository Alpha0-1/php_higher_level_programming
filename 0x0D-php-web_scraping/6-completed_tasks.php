<?php
/**
 * Count completed tasks from JSONPlaceholder API
 * 
 * This script demonstrates API integration and data filtering
 * Usage: php 6-completed_tasks.php <user_id>
 * 
 * @author Alpha0-1
 */

/**
 * Count completed tasks for a specific user
 * 
 * @param int $userId The user ID to check
 * @return void
 */
function countCompletedTasks($userId) {
    // Validate user ID
    if (empty($userId) || !is_numeric($userId)) {
        echo "Usage: php 6-completed_tasks.php <user_id>\n";
        echo "User ID must be a number (1-10)\n";
        return;
    }
    
    $userId = intval($userId);
    
    if ($userId < 1 || $userId > 10) {
        echo "Error: User ID must be between 1 and 10.\n";
        return;
    }
    
    // JSONPlaceholder API endpoint
    $url = "https://jsonplaceholder.typicode.com/todos?userId=$userId";
    
    // Make API request
    $todosData = makeApiRequest($url);
    
    if ($todosData === false) {
        echo "Error: Could not fetch todos data.\n";
        return;
    }
    
    // Parse JSON response
    $todos = json_decode($todosData, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "Error: Invalid JSON response - " . json_last_error_msg() . "\n";
        return;
    }
    
    // Count completed tasks
    $completedCount = 0;
    $totalCount = count($todos);
    
    foreach ($todos as $todo) {
        if (isset($todo['completed']) && $todo['completed'] === true) {
            $completedCount++;
        }
    }
    
    // Display results
    echo "$completedCount\n";
    
    // Additional information for learning
    echo "Total tasks: $totalCount\n";
    echo "Completed: $completedCount\n";
    echo "Remaining: " . ($totalCount - $completedCount) . "\n";
    echo "Completion rate: " . round(($completedCount / $totalCount) * 100, 1) . "%\n";
    
    // Show some example tasks for educational purposes
    echo "\nExample completed tasks:\n";
    $count = 0;
    foreach ($todos as $todo) {
        if (isset($todo['completed']) && $todo['completed'] === true && $count < 3) {
            echo "  - " . $todo['title'] . "\n";
            $count++;
        }
    }
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
        CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; PHP Todos Client)',
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
 * Get user information from JSONPlaceholder API
 * 
 * @param int $userId The user ID
 * @return array|false User data or false on failure
 */
function getUserInfo($userId) {
    $url = "https://jsonplaceholder.typicode.com/users/$userId";
    $userData = makeApiRequest($url);
    
    if ($userData === false) {
        return false;
    }
    
    return json_decode($userData, true);
}

/**
 * Demonstrate all users' task completion
 * 
 * @return void
 */
function demonstrateAllUsers() {
    echo "=== All Users Task Completion Summary ===\n\n";
    
    for ($userId = 1; $userId <= 10; $userId++) {
        $userInfo = getUserInfo($userId);
        $userName = $userInfo ? $userInfo['name'] : "User $userId";
        
        echo "User $userId ($userName):\n";
        countCompletedTasks($userId);
        echo "\n" . str_repeat("-", 40) . "\n\n";
    }
}

// Get user ID from command line arguments
$userId = isset($argv[1]) ? $argv[1] : '';

// If no user ID provided or special command, show demo
if (empty($userId)) {
    echo "Usage: php 6-completed_tasks.php <user_id>\n";
    echo "Or use 'all' to see all users: php 6-completed_tasks.php all\n";
} elseif ($userId === 'all') {
    demonstrateAllUsers();
} else {
    // Execute the function with provided user ID
    countCompletedTasks($userId);
}

?>
