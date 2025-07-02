<?php
/**
 * 7-add_tuple.php
 *
 * This script adds corresponding elements of two arrays (tuples).
 * If arrays have different lengths, only sums up to the minimum length.
 */

function addTuples($arr1, $arr2) {
    $result = [];
    $length = min(count($arr1), count($arr2));

    for ($i = 0; $i < $length; $i++) {
        $result[] = $arr1[$i] + $arr2[$i];
    }

    return $result;
}

// Example usage
$a = [1, 2, 3];
$b = [10, 20, 30];
$result = addTuples($a, $b);

print_r($result);

/**
 * Output:
 * Array
 * (
 *     [0] => 11
 *     [1] => 22
 *     [2] => 33
 * )
 */
?>
