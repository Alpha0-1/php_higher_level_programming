<?php
/**
 * Generates a square matrix where each element is its index squared.
 *
 * @param int $size The size of the matrix (e.g., 3 for a 3x3 matrix)
 * @return array The generated square matrix
 */
function create_square_matrix($size) {
    $matrix = [];

    for ($i = 0; $i < $size; $i++) {
        $row = [];
        for ($j = 0; $j < $size; $j++) {
            $row[] = ($i * $size + $j) * ($i * $size + $j);
        }
        $matrix[] = $row;
    }

    return $matrix;
}

// Example usage
$matrix = create_square_matrix(3);
print_r($matrix);
?>
