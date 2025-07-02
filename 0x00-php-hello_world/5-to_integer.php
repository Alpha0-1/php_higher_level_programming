<?php
/**
 * 5-to_integer.php - String to Integer Conversion
 * 
 * This script demonstrates various methods of converting strings to integers
 * and handling different input types safely.
 * 
 * Learning objectives:
 * - Type casting with (int)
 * - intval() function
 * - Type conversion validation
 * - Error handling for invalid inputs
 * 
 * Usage: php 5-to_integer.php
 */

// Example string numbers
$stringNumbers = ["123", "456.78", "789", "abc123", "0", "-42"];

echo "String to Integer Conversion Examples:\n";
echo "=====================================\n";

foreach ($stringNumbers as $str) {
    // Method 1: Type casting
    $intCast = (int)$str;
    
    // Method 2: intval() function
    $intVal = intval($str);
    
    // Method 3: Adding zero (implicit conversion)
    $intZero = $str + 0;
    
    echo "Original: '$str'\n";
    echo "  (int) cast: $intCast\n";
    echo "  intval(): $intVal\n";
    echo "  +0 method: $intZero\n";
    echo "  is_numeric: " . (is_numeric($str) ? "true" : "false") . "\n";
    echo "---\n";
}

// Practical example with command line argument
if (isset($argv[1])) {
    $input = $argv[1];
    if (is_numeric($input)) {
        $number = (int)$input;
        echo "Command line input '$input' converted to integer: $number\n";
        echo "Double the value: " . ($number * 2) . "\n";
    } else {
        echo "Invalid numeric input: '$input'\n";
    }
}
?>
