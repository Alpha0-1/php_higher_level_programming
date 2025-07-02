<?php
/**
 * Adds only unique integers in an array.
 *
 * @param array $array Array of integers
 * @return int Sum of unique integers
 */
function sum_unique_integers($array) {
    $unique = array_unique($array);
    return array_sum($unique);
}

// Example usage
$input = [1, 2, 2, 3, 4, 4];
echo "Sum of unique integers: " . sum_unique_integers($input) . "\n";
?>
