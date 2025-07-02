<?php
/**
 * 12-switch.php
 *
 * This script swaps the values of two variables using pass-by-reference.
 */

function switchValues(&$a, &$b) {
    list($a, $b) = [$b, $a];
}

// Example usage
$x = 5;
$y = 10;

echo "Before: x=$x, y=$y" . PHP_EOL;
switchValues($x, $y);
echo "After: x=$x, y=$y" . PHP_EOL;

/**
 * Output:
 * Before: x=5, y=10
 * After: x=10, y=5
 */
?>
