<?php
/**
 * 4-new_in_array.php
 *
 * This script replaces an element at a given index but does not modify the original array.
 * Returns a new array with the updated value.
 */

function replaceWithoutModify($array, $index, $value) {
    if (!isset($array[$index])) {
        return $array;
    }

    $newArray = $array;
    $newArray[$index] = $value;
    return $newArray;
}

// Example usage
$original = [1, 2, 3];
$updated = replaceWithoutModify($original, 1, 99);

echo "Original: ";
print_r($original);

echo "Updated: ";
print_r($updated);

/**
 * Output:
 * Original: Array ( [0] => 1 [1] => 2 [2] => 3 )
 * Updated: Array ( [0] => 1 [1] => 99 [2] => 3 )
 */
?>
