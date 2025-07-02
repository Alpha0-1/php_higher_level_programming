<?php
/**
 * 10-factorial.php - Factorial Calculation
 * 
 * This script demonstrates recursive and iterative approaches to calculate
 * the factorial of a number. Shows different algorithmic approaches.
 * 
 * Learning objectives:
 * - Recursive function design
 * - Iterative vs recursive solutions
 * - Mathematical computations
 * - Input validation
 * - Large number handling
 * 
 * Usage: php 10-factorial.php [number]
 * Example: php 10-factorial.php 5
 */

/**
 * Calculate factorial using recursion
 * 
 * @param int $n The number to calculate factorial for
 * @return int The factorial result
 */
function factorialRecursive($n) {
    // Input validation
    if (!is_numeric($n) || $n < 0) {
        return "Error: Input must be a non-negative integer";
    }
    
    $n = (int)$n;
    
    // Base cases
    if ($n == 0 || $n == 1) {
        return 1;
    }
    
    // Recursive case
    return $n * factorialRecursive($n - 1);
}

/**
 * Calculate factorial using iteration
 * 
 * @param int $n The number to calculate factorial for
 * @return int The factorial result
 */
function factorialIterative($n) {
    // Input validation
    if (!is_numeric($n) || $n < 0) {
        return "Error: Input must be a non-negative integer";
    }
    
    $n = (int)$n;
    $result = 1;
    
    // Iterative calculation
    for ($i = 2; $i <= $n; $i++) {
        $result *= $i;
    }
    
    return $result;
}

/**
 * Calculate factorial with step-by-step display
 * 
 * @param int $n The number to calculate factorial for
 * @return int The factorial result
 */
function factorialVerbose($n) {
    if (!is_numeric($n) || $n < 0) {
        return "Error: Input must be a non-negative integer";
    }
    
    $n = (int)$n;
    
    if ($n == 0 || $n == 1) {
        echo "$n! = 1\n";
        return 1;
    }
    
    $result = 1;
    $expression = "$n! = ";
    $steps = [];
    
    for ($i = $n; $i >= 1; $i--) {
        $steps[] = $i;
        $result *= $i;
    }
    
    $expression .= implode(" × ", $steps) . " = $result";
    echo "$expression\n";
    
    return $result;
}

// Main execution
echo "Factorial Calculator\n";
echo "===================\n";

// Get number from command line or use default
$number = isset($argv[1]) && is_numeric($argv[1]) ? (int)$argv[1] : 5;

echo "Calculating factorial of $number:\n\n";

// Method 1: Recursive
echo "1. Recursive Method:\n";
$result1 = factorialRecursive($number);
echo "factorialRecursive($number) = $result1\n\n";

// Method 2: Iterative
echo "2. Iterative Method:\n";
$result2 = factorialIterative($number);
echo "factorialIterative($number) = $result2\n\n";

// Method 3: Verbose
echo "3. Step-by-step Method:\n";
$result3 = factorialVerbose($number);

// Test cases
echo "\nTest Cases:\n";
echo "============\n";

$testNumbers = [0, 1, 3, 4, 6, 8];
foreach ($testNumbers as $testNum) {
    $recursive = factorialRecursive($testNum);
    $iterative = factorialIterative($testNum);
    echo "$testNum! = $recursive (recursive) = $iterative (iterative)\n";
}

// Performance comparison for larger numbers
echo "\nPerformance Test (n=10):\n";
echo "========================\n";

$start = microtime(true);
factorialRecursive(10);
$recursiveTime = microtime(true) - $start;

$start = microtime(true);
factorialIterative(10);
$iterativeTime = microtime(true) - $start;

echo "Recursive time: " . number_format($recursiveTime * 1000000, 2) . " microseconds\n";
echo "Iterative time: " . number_format($iterativeTime * 1000000, 2) . " microseconds\n";
?>
