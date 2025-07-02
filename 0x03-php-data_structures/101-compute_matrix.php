<?php
/**
 * 101-compute_matrix.php
 *
 * This script performs basic matrix operations: transpose and sum.
 */

function transposeMatrix($matrix) {
    $transposed = [];

    foreach ($matrix as $rowIndex => $row) {
        foreach ($row as $colIndex => $value) {
            $transposed[$colIndex][$rowIndex] = $value;
        }
    }

    return $transposed;
}

function sumMatrix($matrix) {
    $sum = 0;

    foreach ($matrix as $row) {
        foreach ($row as $value) {
            $sum += $value;
        }
    }

    return $sum;
}

// Example usage
$matrix = [
    [1, 2],
    [3, 4]
];

echo "Original Matrix:" . PHP_EOL;
print_r($matrix);

echo "Transposed Matrix:" . PHP_EOL;
print_r(transposeMatrix($matrix));

echo "Sum of Matrix Elements: " . sumMatrix($matrix) . PHP_EOL;

/**
 * Output:
 * Original Matrix:
 * Array
 * (
 *     [0] => Array ( [0] => 1 [1] => 2 )
 *     [1] => Array ( [0] => 3 [1] => 4 )
 * )
 * Transposed Matrix:
 * Array
 * (
 *     [0] => Array ( [0] => 1 [1] => 3 )
 *     [1] => Array ( [0] => 2 [1] => 4 )
 * )
 * Sum of Matrix Elements: 10
 */
?>
