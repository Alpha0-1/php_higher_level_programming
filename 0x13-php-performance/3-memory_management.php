<?php
/**
 * Memory Optimization in PHP
 * 
 * Techniques to reduce memory usage and improve application performance.
 */

/**
 * 1. Unset variables when no longer needed
 */
function processLargeData(): void
{
    $largeDataSet = getLargeDataSet(); // 100MB of data
    
    // Process data
    $result = [];
    foreach ($largeDataSet as $item) {
        $result[] = processItem($item);
    }
    
    // Free memory when done
    unset($largeDataSet);
    
    // Continue with result processing
    processResults($result);
}

/**
 * 2. Use generators for large datasets
 */
function generateLargeDataset(): Generator
{
    for ($i = 0; $i < 1000000; $i++) {
        yield $i => expensiveOperation($i);
    }
}

function processWithGenerator(): void
{
    foreach (generateLargeDataset() as $key => $value) {
        // Process one item at a time
        // Memory remains constant regardless of dataset size
        processItem($value);
    }
}

/**
 * 3. Avoid unnecessary variable copies
 */
function avoidCopies(): void
{
    $largeArray = range(1, 100000);
    
    // Bad: Creates copy of array
    // $filtered = array_filter($largeArray, function($x) { return $x % 2; });
    
    // Good: Process directly
    foreach ($largeArray as &$value) {
        if ($value % 2 === 0) {
            $value = processItem($value);
        }
    }
    unset($value); // Always unset reference variables
}

/**
 * 4. Efficient data structures
 */
function efficientStructures(): void
{
    // SplFixedArray uses less memory for numeric indexes
    $fixedArray = new SplFixedArray(100000);
    for ($i = 0; $i < 100000; $i++) {
        $fixedArray[$i] = $i;
    }
}

/**
 * 5. Memory profiling
 */
function profileMemory(): void
{
    $startMemory = memory_get_usage();
    
    $data = [];
    for ($i = 0; $i < 10000; $i++) {
        $data[] = [
            'id' => $i,
            'name' => 'Item ' . $i,
            'value' => $i * 10
        ];
    }
    
    $endMemory = memory_get_usage();
    echo "Memory used: " . ($endMemory - $startMemory) / 1024 . " KB\n";
}

/**
 * Key Takeaways:
 * 1. Be mindful of memory usage with large datasets
 * 2. Generators can significantly reduce memory overhead
 * 3. Always free resources when done
 */
?>
