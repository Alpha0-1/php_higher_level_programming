<?php
/**
 * 9-max_integer.php
 *
 * This script finds the maximum integer in an array.
 * Returns null if array is empty or has no integers.
 */

function maxInteger($array) {
    if (empty($array)) {
        return null;
    }

    $max = PHP_INT_MIN;
    foreach ($array as $num) {
        if (is_int($num) && $num > $max) {
            $max = $num;
        }
    }

    return $max;
}

// Example usage
$values = [10, -5, 30, 22, 100];
echo "Max: " . maxInteger($values) . PHP_EOL;

/**
 * Output:
 * Max: 100
 */
?>
