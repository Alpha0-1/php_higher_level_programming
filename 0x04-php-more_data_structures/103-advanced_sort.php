<?php
/**
 * Sorts an associative array by value or key.
 *
 * @param array $array Input associative array
 * @param string $type 'value' or 'key'
 * @param bool $desc Descending order flag
 * @return array Sorted array
 */
function advanced_sort($array, $type = 'value', $desc = false) {
    if ($type === 'value') {
        if ($desc) {
            arsort($array);
        } else {
            asort($array);
        }
    } elseif ($type === 'key') {
        if ($desc) {
            krsort($array);
        } else {
            ksort($array);
        }
    } else {
        echo "Invalid sort type. Use 'value' or 'key'.\n";
    }

    return $array;
}

// Example usage
$data = ['b' => 3, 'a' => 1, 'c' => 2];
print_r(advanced_sort($data, 'value', true));
?>
