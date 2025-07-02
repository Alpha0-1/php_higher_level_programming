<?php
/**
 * Replaces all occurrences of a search value with a replacement in an array.
 *
 * @param array $array The input array
 * @param mixed $search_value The value to replace
 * @param mixed $replace_value The replacement value
 * @return array Modified array with replacements
 */
function search_and_replace($array, $search_value, $replace_value) {
    foreach ($array as &$value) {
        if ($value === $search_value) {
            $value = $replace_value;
        }
    }
    unset($value); // Unset reference
    return $array;
}

// Example usage
$input = [1, 2, 3, 2, 4];
$result = search_and_replace($input, 2, 'two');
print_r($result);
?>
