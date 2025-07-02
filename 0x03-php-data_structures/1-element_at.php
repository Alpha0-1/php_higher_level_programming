<?php
/**
 * 1-element_at.php
 *
 * This script retrieves the element at a specific index in an array.
 * If the index is out of bounds, it returns null.
 */

function getElementAtIndex($array, $index) {
    if (isset($array[$index])) {
        return $array[$index];
    }
    return null;
}

// Example usage
$fruits = ['apple', 'banana', 'cherry'];
echo "Element at index 1: " . getElementAtIndex($fruits, 1) . PHP_EOL; // banana
echo "Element at index 5: " . getElementAtIndex($fruits, 5) . PHP_EOL; // null

/**
 * Output:
 * Element at index 1: banana
 * Element at index 5:
 */
?>
