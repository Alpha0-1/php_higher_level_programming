<?php
/**
 * Creates a square matrix using array_map.
 *
 * @param int $size Size of matrix
 * @return array Square matrix
 */
function square_matrix_with_map($size) {
    $base = range(0, $size * $size - 1);

    return array_chunk(array_map(function($index) use ($size) {
        return $index * $index;
    }, $base), $size);
}

// Example usage
print_r(square_matrix_with_map(3));
?>
