<?php
/**
 * 2-replace_in_array.php
 *
 * This script replaces an element at a given index in an array.
 * It modifies the original array.
 */

function replaceInArray(&$array, $index, $value) {
    if (isset($array[$index])) {
        $array[$index] = $value;
    } else {
        echo "Index out of bounds." . PHP_EOL;
    }
}

// Example usage
$colors = ['red', 'green', 'blue'];
replaceInArray($colors, 1, 'yellow');

print_r($colors);

/**
 * Output:
 * Array
 * (
 *     [0] => red
 *     [1] => yellow
 *     [2] => blue
 * )
 */
?>
