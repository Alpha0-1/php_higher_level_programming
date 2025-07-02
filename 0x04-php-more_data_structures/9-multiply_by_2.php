<?php
/**
 * Multiplies all numeric values in an array by 2.
 *
 * @param array $array Input array
 * @return array Array with numeric values doubled
 */
function multiply_by_two($array) {
    foreach ($array as &$value) {
        if (is_numeric($value)) {
            $value *= 2;
        }
    }
    unset($value);
    return $array;
}

// Example usage
$input = [1, 2, 'text', 3.5];
$result = multiply_by_two($input);
print_r($result);
?>
