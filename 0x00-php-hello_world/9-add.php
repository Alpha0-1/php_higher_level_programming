<?php
/**
 * 9-add.php - Addition Function
 * 
 * This script demonstrates function definition, parameters, and return values.
 * Shows how to create reusable code blocks with functions.
 * 
 * Learning objectives:
 * - Function definition syntax
 * - Parameters and arguments
 * - Return statements
 * - Function calling
 * - Type validation in functions
 * 
 * Usage: php 9-add.php [num1] [num2]
 * Example: php 9-add.php 15 25
 */

/**
 * Add two numbers together
 * 
 * @param float $a First number
 * @param float $b Second number
 * @return float Sum of the two numbers
 */
function add($a, $b) {
    // Type validation
    if (!is_numeric($a) || !is_numeric($b)) {
        return "Error: Both parameters must be numeric";
    }
    
    return $a + $b;
}

/**
 * Enhanced addition function with multiple parameters
 * 
 * @param array $numbers Array of numbers to add
 * @return float Sum of all numbers
 */
function addMultiple($numbers) {
    if (!is_array($numbers)) {
        return "Error: Parameter must be an array";
    }
    
    $sum = 0;
    foreach ($numbers as $number) {
        if (!is_numeric($number)) {
            return "Error: All array elements must be numeric";
        }
        $sum += $number;
    }
    
    return $sum;
}

// Test the functions
echo "Addition Function Examples:\n";
echo "===========================\n";

// Example 1: Basic addition
$result1 = add(10, 20);
echo "add(10, 20) = $result1\n";

// Example 2: Decimal numbers
$result2 = add(3.14, 2.86);
echo "add(3.14, 2.86) = $result2\n";

// Example 3: Command line arguments
if (isset($argv[1]) && isset($argv[2])) {
    $num1 = $argv[1];
    $num2 = $argv[2];
    $result3 = add($num1, $num2);
    echo "add($num1, $num2) = $result3\n";
}

// Example 4: Error handling
$result4 = add("abc", 5);
echo "add('abc', 5) = $result4\n";

// Example 5: Multiple number addition
$numbers = [1, 2, 3, 4, 5];
$result5 = addMultiple($numbers);
echo "addMultiple([1, 2, 3, 4, 5]) = $result5\n";

// Example 6: Interactive addition
echo "\nInteractive Examples:\n";
$testCases = [
    [5, 7],
    [100, 200],
    [-10, 25],
    [0.5, 0.3]
];

foreach ($testCases as $case) {
    $sum = add($case[0], $case[1]);
    echo "add({$case[0]}, {$case[1]}) = $sum\n";
}
?>
