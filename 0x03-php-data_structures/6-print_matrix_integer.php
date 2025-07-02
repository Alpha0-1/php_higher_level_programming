<?php
/**
 * 6-print_matrix_integer.php
 *
 * This script prints a matrix (2D array) row by row.
 */

function printMatrixInteger($matrix) {
    foreach ($matrix as $row) {
        echo implode(" ", $row) . PHP_EOL;
    }
}

// Example usage
$matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
];

printMatrixInteger($matrix);

/**
 * Output:
 * 1 2 3
 * 4 5 6
 * 7 8 9
 */
?>
