<?php
// 102-magic_calculation.php
/**
 * Performs magic calculation based on input
 * Example: php 102-magic_calculation.php add 5 3
 * Output: Result: 8
 */

function magicCalculation(string $op, float $a, float $b): float {
    switch ($op) {
        case 'add': return $a + $b;
        case 'sub': return $a - $b;
        case 'mul': return $a * $b;
        case 'div': return $b != 0 ? $a / $b : INF;
        default: throw new Exception("Unknown operation");
    }
}

try {
    $result = magicCalculation($argv[1], $argv[2], $argv[3]);
    echo "Result: $result\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
