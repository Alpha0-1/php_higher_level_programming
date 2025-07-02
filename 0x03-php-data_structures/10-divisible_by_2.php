<?php
/**
 * 10-divisible_by_2.php
 *
 * This script filters and returns all numbers divisible by 2 from an array.
 */

function divisibleByTwo($array) {
    $result = [];

    foreach ($array as $num) {
        if ($num % 2 === 0) {
            $result[] = $num;
        }
    }

    return $result;
}

// Example usage
$numbers = [1, 2, 3, 4, 5, 6];
$evenNumbers = divisibleByTwo($numbers);

print_r($evenNumbers);

/**
 * Output:
 * Array
 * (
 *     [0] => 2
 *     [1] => 4
 *     [2] => 6
 * )
 */
?>
