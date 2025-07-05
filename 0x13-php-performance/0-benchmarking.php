<?php
/**
 * Performance Benchmarking in PHP
 * 
 * This script demonstrates how to measure execution time and memory usage
 * of different code implementations to identify performance bottlenecks.
 */

/**
 * Function to benchmark execution time of a callable
 * 
 * @param callable $function The function to benchmark
 * @param string $name Test name for output
 * @param int $iterations Number of iterations to run
 */
function benchmark(callable $function, string $name, int $iterations = 1000): void
{
    $startTime = microtime(true);
    
    for ($i = 0; $i < $iterations; $i++) {
        $function();
    }
    
    $endTime = microtime(true);
    $totalTime = ($endTime - $startTime) * 1000; // Convert to milliseconds
    
    echo "Benchmark: {$name}\n";
    echo "Iterations: {$iterations}\n";
    echo "Total Time: {$totalTime}ms\n";
    echo "Average Time: " . ($totalTime / $iterations) . "ms per iteration\n\n";
}

// Example 1: String concatenation methods
benchmark(function() {
    $str = '';
    for ($i = 0; $i < 100; $i++) {
        $str .= 'a';
    }
}, "String concatenation with .=");

benchmark(function() {
    $parts = [];
    for ($i = 0; $i < 100; $i++) {
        $parts[] = 'a';
    }
    implode('', $parts);
}, "String building with array and implode");

// Example 2: Memory usage comparison
function testMemoryUsage1() {
    $data = range(1, 10000);
    // Do something with data
}

function testMemoryUsage2() {
    $data = [];
    for ($i = 1; $i <= 10000; $i++) {
        $data[] = $i;
    }
    // Do something with data
}

echo "Memory usage test 1: " . memory_get_peak_usage(true) . " bytes\n";
testMemoryUsage1();
echo "Memory after test 1: " . memory_get_peak_usage(true) . " bytes\n\n";

echo "Memory usage test 2: " . memory_get_peak_usage(true) . " bytes\n";
testMemoryUsage2();
echo "Memory after test 2: " . memory_get_peak_usage(true) . " bytes\n";

/**
 * Key Takeaways:
 * 1. Always measure before optimizing
 * 2. Different approaches can have significant performance impacts
 * 3. Consider both execution time and memory usage
 */
?>
