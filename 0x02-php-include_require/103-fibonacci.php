<!-- 103-fibonacci.php -->
<?php
/**
 * Fibonacci Sequence
 * Generates Fibonacci numbers up to N
 * @author Your Name
 * @license MIT
 */

function generateFibonacci($limit) {
    $sequence = [];
    $a = 0;
    $b = 1;
    
    while ($a <= $limit) {
        $sequence[] = $a;
        $next = $a + $b;
        $a = $b;
        $b = $next;
    }
    
    return $sequence;
}

// Example usage
$fibonacci = generateFibonacci(100);
echo "Fibonacci sequence up to 100:\n";
print_r($fibonacci);
