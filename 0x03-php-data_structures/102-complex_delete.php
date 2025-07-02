<?php
/**
 * 102-complex_delete.php
 *
 * This script deletes all occurrences of a specific value from an array.
 */

function deleteByValue($array, $value) {
    return array_values(array_diff($array, [$value]));
}

// Example usage
$data = [10, 20, 10, 30, 10, 40];
$result = deleteByValue($data, 10);

print_r($result);

/**
 * Output:
 * Array
 * (
 *     [0] => 20
 *     [1] => 30
 *     [2] => 40
 * )
 */
?>
