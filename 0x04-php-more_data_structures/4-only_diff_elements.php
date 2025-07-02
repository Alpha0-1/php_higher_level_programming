<?php
/**
 * Returns elements that appear in only one of the arrays.
 *
 * @param array $arr1 First array
 * @param array $arr2 Second array
 * @return array Elements unique to either array
 */
function diff_elements($arr1, $arr2) {
    $union = array_merge($arr1, $arr2);
    $counts = array_count_values($union);

    $result = [];
    foreach ($counts as $val => $count) {
        if ($count == 1) {
            $result[] = $val;
        }
    }

    return $result;
}

// Example usage
$a = [1, 2, 3];
$b = [2, 3, 4];
print_r(diff_elements($a, $b));
?>
