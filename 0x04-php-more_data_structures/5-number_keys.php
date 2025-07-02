<?php
/**
 * Counts the number of keys in an array.
 *
 * @param array $array Input array
 * @return int Number of keys
 */
function count_keys($array) {
    return count(array_keys($array));
}

// Example usage
$data = ['a' => 1, 'b' => 2, 'c' => 3];
echo "Number of keys: " . count_keys($data) . "\n";
?>
