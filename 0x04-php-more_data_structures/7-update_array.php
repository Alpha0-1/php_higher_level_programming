<?php
/**
 * Updates a value in an associative array.
 *
 * @param array $array Associative array
 * @param string|int $key Key to update
 * @param mixed $new_value New value
 * @return array Updated array
 */
function update_assoc_array($array, $key, $new_value) {
    if (array_key_exists($key, $array)) {
        $array[$key] = $new_value;
    } else {
        echo "Key '$key' does not exist.\n";
    }
    return $array;
}

// Example usage
$data = ['name' => 'Alice', 'age' => 25];
$data = update_assoc_array($data, 'age', 26);
print_r($data);
?>
