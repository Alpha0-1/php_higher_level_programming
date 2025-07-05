<?php
/**
 * Code Optimization Techniques in PHP
 * 
 * This script demonstrates various PHP code optimization strategies.
 */

/**
 * 1. Efficient Loop Structures
 */
function optimizedLoopExample(array $largeArray): array
{
    // Bad: count() called in each iteration
    // for ($i = 0; $i < count($largeArray); $i++) { ... }
    
    // Good: count calculated once
    $count = count($largeArray);
    $result = [];
    
    for ($i = 0; $i < $count; $i++) {
        // Pre-increment is slightly faster than post-increment
        ++$result[$i];
    }
    
    return $result;
}

/**
 * 2. String Performance
 */
function stringOptimizations(): void
{
    // Single vs double quotes
    $single = 'This is a string'; // Faster for literals
    $double = "This is a $single"; // Only use when needing variable interpolation
    
    // Concatenation
    $output = '';
    for ($i = 0; $i < 100; $i++) {
        // Bad: Creates new string each iteration
        // $output = $output . $i;
        
        // Good: Uses temporary array
        $output .= $i;
    }
}

/**
 * 3. Function Call Optimization
 */
function expensiveOperation(): int
{
    usleep(1000); // Simulate expensive operation
    return rand(1, 100);
}

function optimizedFunctionCalls(): void
{
    // Bad: Calling function in loop condition
    // for ($i = 0; $i < expensiveOperation(); $i++) { ... }
    
    // Good: Call once before loop
    $limit = expensiveOperation();
    for ($i = 0; $i < $limit; $i++) {
        // Do something
    }
}

/**
 * 4. Array Optimization
 */
function arrayOptimizations(): void
{
    // Pre-size arrays when possible
    $size = 10000;
    $optimizedArray = array_fill(0, $size, null); // Pre-allocated
    
    // Use appropriate array functions
    $data = range(1, 100);
    
    // Bad: Using array_merge in loop
    // $result = [];
    // foreach ($data as $value) {
    //     $result = array_merge($result, process($value));
    // }
    
    // Good: Using array_push with spread operator (PHP 7.4+)
    $result = [];
    foreach ($data as $value) {
        array_push($result, ...process($value));
    }
}

/**
 * 5. Type Declarations
 */
function typeOptimizations(int $count, string $name): array
{
    // Strict types improve performance and prevent type juggling
    $result = [];
    
    for ($i = 0; $i < $count; $i++) {
        $result[] = "{$name}_{$i}";
    }
    
    return $result;
}

/**
 * Key Takeaways:
 * 1. Profile before optimizing
 * 2. Small optimizations add up in large-scale applications
 * 3. Readability vs. optimization trade-offs
 */
?>
