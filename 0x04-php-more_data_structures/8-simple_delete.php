<?php
/**
 * Deletes a key from an associative array.
 *
 * @param array $array Associative array
 * @param string|int $key Key to delete
 * @return array Updated array
 */
function delete_assoc_key($array, $key) {
    if (array_key_exists($key, $array)) {
        unset($array[$key]);
    } else {
        echo "Key '$key' does not exist.\n";
    }
    return $array;
}

// Example usage
$data = ['name' => 'Bob', 'age' => 30];
$data = delete_assoc_key($data, 'age');
print_r($data);
?>
