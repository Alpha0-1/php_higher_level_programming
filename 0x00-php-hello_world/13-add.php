<?php
/**
 * 13-add.php - Reusable Addition Function
 * 
 * This file contains a reusable addition function that can be included
 * in other PHP scripts. Demonstrates code modularity and reusability.
 * 
 * Learning objectives:
 * - Function modularity
 * - Code reusability
 * - Include/require concepts
 * - Function libraries
 * 
 * Usage: Include this file in other scripts
 * Example: include_once '13-add.php';
 */

if (!function_exists('add')) {
    /**
     * Add two or more numbers
     * 
     * @param mixed ...$numbers Variable number of arguments
     * @return float|string Sum of numbers or error message
     */
    function add(...$numbers) {
        // Check if any arguments provided
        if (empty($numbers)) {
            return "Error: No numbers provided";
        }
        
        $sum = 0;
        
        // Validate and sum all numbers
        foreach ($numbers as $number) {
            if (!is_numeric($number)) {
                return "Error: All arguments must be numeric";
            }
            $sum += $number;
        }
        
        return $sum;
    }
}

if (!function_exists('addArray')) {
    /**
     * Add numbers from an array
     * 
     * @param array $numbers Array of numbers to add
     * @return float|string Sum of numbers or error message
     */
    function addArray($numbers) {
        if (!is_array($numbers)) {
            return "Error: Parameter must be an array";
        }
        
        if (empty($numbers)) {
            return "Error: Array is empty";
        }
        
        return add(...$numbers);
    }
}

if (!function_exists('addPositive')) {
    /**
     * Add only positive numbers
     * 
     * @param mixed ...$numbers Variable number of arguments
     * @return float|string Sum of positive numbers or error message
     */
    function addPositive(...$numbers) {
        if (empty($numbers)) {
            return "Error: No numbers provided";
        }
        
        $positiveNumbers = [];
        
        foreach ($numbers as $number) {
            if (!is_numeric($number)) {
                return "Error: All arguments must be numeric";
            }
            
            if ($number > 0) {
                $positiveNumbers[] = $number;
            }
        }
        
        if (empty($positiveNumbers)) {
            return 0; // No positive numbers found
        }
        
        return array_sum($positiveNumbers);
    }
}

// If this file is run directly, provide examples
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    echo "Addition Function Library - Examples\n";
    echo "===================================\n";
    
    // Basic addition examples
    echo "Basic addition:\n";
    echo "add(5, 10) = " . add(5, 10) . "\n";
    echo "add(1, 2, 3, 4, 5) = " . add(1, 2, 3, 4, 5) . "\n";
    echo "add(3.14, 2.86) = " . add(3.14, 2.86) . "\n";
    
    // Array addition
    echo "\nArray addition:\n";
    $numbers = [10, 20, 30, 40];
    echo "addArray([10, 20, 30, 40]) = " . addArray($numbers) . "\n";
    
    // Positive number addition
    echo "\nPositive number addition:\n";
    echo "addPositive(-5, 10, -3, 7, 2) = " . addPositive(-5, 10, -3, 7, 2) . "\n";
    
    // Error cases
    echo "\nError handling:\n";
    echo "add() = " . add() . "\n";
    echo "add('abc', 5) = " . add('abc', 5) . "\n";
    echo "addArray('not an array') = " . addArray('not an array') . "\n";
    
    // Command line usage
    if ($argc > 1) {
        echo "\nCommand line input:\n";
        $cmdNumbers = array_slice($argv, 1);
        $result = add(...$cmdNumbers);
        echo "add(" . implode(", ", $cmdNumbers) . ") = $result\n";
    }
}
?>

