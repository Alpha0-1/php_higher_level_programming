<?php
/**
 * Function to return a deep copy of an array.
 *
 * @param array $array The input array to copy.
 * @return array A new array with independent values.
 */
function copy_array($array) {
    return unserialize(serialize($array));
}

// Example usage
$original = ['a' => 1, 'b' => [2, 3]];
$copied = copy_array($original);

// Modify original
$original['b'][0] = 99;

echo "Original: ";
print_r($original);
echo "Copied: ";
print_r($copied);
?>
