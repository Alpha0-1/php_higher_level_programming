<?php
/**
 * 103-compare_arrays.php
 *
 * This script compares two arrays and checks if they are identical.
 */

function compareArrays($arr1, $arr2) {
    if (count($arr1) !== count($arr2)) {
        return false;
    }

    foreach ($arr1 as $key => $value) {
        if (!array_key_exists($key, $arr2) || $arr2[$key] !== $value) {
            return false;
        }
    }

    return true;
}

// Example usage
$a = [1, 2, 3];
$b = [1, 2, 3];
$c = [1, 3, 2];

var_dump(compareArrays($a, $b)); // true
var_dump(compareArrays($a, $c)); // false

/**
 * Output:
 * bool(true)
 * bool(false)
 */
?>
