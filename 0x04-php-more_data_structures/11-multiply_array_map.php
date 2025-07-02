<?php
/**
 * Multiplies all values in an array by 2 using array_map.
 *
 * @param array $array Input array
 * @return array Resulting array
 */
function multiply_with_map($array) {
    return array_map(function($value) {
        return is_numeric($value) ? $value * 2 : $value;
    }, $array);
}

// Example usage
$input = [1, 2, 3, 4];
$result = multiply_with_map($input);
print_r($result);
?>
