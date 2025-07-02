<?php
/**
 * Returns elements common to both arrays.
 *
 * @param array $arr1 First array
 * @param array $arr2 Second array
 * @return array Common elements
 */
function find_common_elements($arr1, $arr2) {
    return array_values(array_intersect($arr1, $arr2));
}

// Example usage
$a = [1, 2, 3, 4];
$b = [3, 4, 5, 6];
print_r(find_common_elements($a, $b));
?>
