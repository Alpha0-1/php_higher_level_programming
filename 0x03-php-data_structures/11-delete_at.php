<?php
/**
 * 11-delete_at.php
 *
 * This script deletes an element at a specific index in an array.
 * Returns a new array without modifying the original.
 */

function deleteAt($array, $index) {
    if (!isset($array[$index])) {
        return $array;
    }

    unset($array[$index]);
    return array_values($array); // Reindex array
}

// Example usage
$original = [10, 20, 30, 40];
$newArray = deleteAt($original, 2);

print_r($original);
print_r($newArray);

/**
 * Output:
 * Array
 * (
 *     [0] => 10
 *     [1] => 20
 *     [2] => 30
 *     [3] => 40
 * )
 * Array
 * (
 *     [0] => 10
 *     [1] => 20
 *     [2] => 40
 * )
 */
?>
