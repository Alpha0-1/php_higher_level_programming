<?php
/**
 * 3-print_reversed_array.php
 *
 * This script prints the elements of an array in reverse order.
 */

function printReversedArray($array) {
    $reversed = array_reverse($array);
    foreach ($reversed as $item) {
        echo $item . PHP_EOL;
    }
}

// Example usage
$letters = ['a', 'b', 'c'];
printReversedArray($letters);

/**
 * Output:
 * c
 * b
 * a
 */
?>
