<?php
// 13-insert_number.php
/**
 * Inserts number into sorted array
 * Example: php 13-insert_number.php 5
 * Output: [1,3,4,5,7,9]
 */

function insertSorted(array $arr, int $num): array {
    $index = 0;
    foreach ($arr as $key => $value) {
        if ($value < $num) $index = $key + 1;
    }
    array_splice($arr, $index, 0, [$num]);
    return $arr;
}

$sorted = [1, 3, 4, 7, 9];
$newArr = insertSorted($sorted, $argv[1] ?? 0);
print_r($newArr);
?>
