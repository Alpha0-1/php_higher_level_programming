<?php
/**
 * Deletes multiple keys from an associative array.
 *
 * @param array $array Input array
 * @param array $keys_to_delete Keys to delete
 * @return array Updated array
 */
function complex_delete($array, $keys_to_delete) {
    foreach ($keys_to_delete as $key) {
        if (array_key_exists($key, $array)) {
            unset($array[$key]);
        }
    }
    return $array;
}

// Example usage
$data = ['name' => 'John', 'age' => 25, 'city' => 'New York'];
$data = complex_delete($data, ['age', 'city']);
print_r($data);
?>
