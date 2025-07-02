<?php
/**
 * 11-second_biggest.php - Find Second Largest Number
 * 
 * This script demonstrates array processing to find the second largest
 * number in an array. Shows various approaches and edge case handling.
 * 
 * Learning objectives:
 * - Array manipulation
 * - Sorting algorithms
 * - Edge case handling
 * - Multiple solution approaches
 * - Array functions
 * 
 * Usage: php 11-second_biggest.php [numbers...]
 * Example: php 11-second_biggest.php 10 25 5 30 15
 */

/**
 * Find second largest number using sorting
 * 
 * @param array $numbers Array of numbers
 * @return mixed Second largest number or error message
 */
function secondLargestSort($numbers) {
    if (!is_array($numbers) || count($numbers) < 2) {
        return "Error: Need at least 2 numbers";
    }
    
    // Remove duplicates and sort in descending order
    $uniqueNumbers = array_unique($numbers);
    
    if (count($uniqueNumbers) < 2) {
        return "Error: Need at least 2 different numbers";
    }
    
    rsort($uniqueNumbers);
    return $uniqueNumbers[1];
}

/**
 * Find second largest number using single pass
 * 
 * @param array $numbers Array of numbers
 * @return mixed Second largest number or error message
 */
function secondLargestSinglePass($numbers) {
    if (!is_array($numbers) || count($numbers) < 2) {
        return "Error: Need at least 2 numbers";
    }
    
    $largest = $secondLargest = PHP_INT_MIN;
    
    foreach ($numbers as $number) {
        if (!is_numeric($number)) {
            return "Error: All elements must be numeric";
        }
        
        $number = (float)$number;
        
        if ($number > $largest) {
            $secondLargest = $largest;
            $largest = $number;
        } elseif ($number > $secondLargest && $number != $largest) {
            $secondLargest = $number;
        }
    }
    
    if ($secondLargest == PHP_INT_MIN) {
        return "Error: All numbers are the same";
    }
    
    return $secondLargest;
}

/**
 * Find second largest with detailed analysis
 * 
 * @param array $numbers Array of numbers
 * @return array Analysis results
 */
function analyzeNumbers($numbers) {
    if (!is_array($numbers) || count($numbers) < 2) {
        return ["error" => "Need at least 2 numbers"];
    }
    
    $stats = [
        "original" => $numbers,
        "count" => count($numbers),
        "unique_count" => count(array_unique($numbers)),
        "min" => min($numbers),
        "max" => max($numbers),
        "average" => array_sum($numbers) / count($numbers)
    ];
    
    $secondLargest = secondLargestSinglePass($numbers);
    $stats["second_largest"] = $secondLargest;
    
    return $stats;
}

// Main execution
echo "Second Largest Number Finder\n";
echo "============================\n";

// Test with command line arguments
if ($argc > 1) {
    $inputNumbers = array_slice($argv, 1);
    
    // Convert to numeric array
    $numbers = [];
    foreach ($inputNumbers as $input) {
        if (is_numeric($input)) {
            $numbers[] = (float)$input;
        }
    }
    
    if (!empty($numbers)) {
        echo "Input numbers: " . implode(", ", $numbers) . "\n";
        
        $result1 = secondLargestSort($numbers);
        $result2 = secondLargestSinglePass($numbers);
        
        echo "Method 1 (sorting): $result1\n";
        echo "Method 2 (single pass): $result2\n";
        
        $analysis = analyzeNumbers($numbers);
        echo "\nDetailed Analysis:\n";
        foreach ($analysis as $key => $value) {
            if ($key != "original") {
                echo "  " . ucfirst(str_replace("_", " ", $key)) . ": $value\n";
            }
        }
    } else {
        echo "No valid numbers provided.\n";
    }
} else {
    // Test with predefined arrays
    $testCases = [
        [1, 2, 3, 4, 5],
        [10, 10, 10],
        [100, 50, 75, 25],
        [7.5, 3.2, 9.1, 6.8],
        [-5, -2, -8, -1],
        [42],
        []
    ];
    
    foreach ($testCases as $index => $testCase) {
        echo "\nTest Case " . ($index + 1) . ": [" . implode(", ", $testCase) . "]\n";
        echo "Sort method: " . secondLargestSort($testCase) . "\n";
        echo "Single pass: " . secondLargestSinglePass($testCase) . "\n";
    }
}

// Performance comparison
echo "\nPerformance Comparison:\n";
echo "======================\n";

$largeArray = range(1, 1000);
shuffle($largeArray);

$start = microtime(true);
secondLargestSort($largeArray);
$sortTime = microtime(true) - $start;

$start = microtime(true);
secondLargestSinglePass($largeArray);
$singlePassTime = microtime(true) - $start;

echo "Array size: " . count($largeArray) . " elements\n";
echo "Sort method: " . number_format($sortTime * 1000, 4) . " ms\n";
echo "Single pass: " . number_format($singlePassTime * 1000, 4) . " ms\n";
echo "Single pass is " . number_format($sortTime / $singlePassTime, 2) . "x faster\n";
?>
