<?php
/**
 * Sorts and prints an array.
 *
 * @param array $array Input array
 */
function print_sorted_array($array) {
    sort($array);
    print_r($array);
}

// Example usage
$input = [3, 1, 4, 1, 5, 9];
print_sorted_array($input);
?>
