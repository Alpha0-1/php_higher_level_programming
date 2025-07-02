<?php
/**
 * 3-value_argument.php - Argument Existence Check
 * 
 * This script checks if a specific command-line argument exists and displays it.
 * Demonstrates conditional logic and safe array access.
 * 
 * Learning objectives:
 * - Conditional statements (if/else)
 * - Array bounds checking
 * - Safe argument access
 * 
 * Usage: php 3-value_argument.php <value>
 * Example: php 3-value_argument.php "Learning PHP"
 */

// Check if at least one argument is provided (besides script name)
if (isset($argv[1])) {
    echo "Value: " . $argv[1] . "\n";
} else {
    echo "No value provided\n";
}

// Alternative method using $argc
if ($argc >= 2) {
    echo "Confirmed value exists: " . $argv[1] . "\n";
} else {
    echo "Please provide a value as argument\n";
}
?>
