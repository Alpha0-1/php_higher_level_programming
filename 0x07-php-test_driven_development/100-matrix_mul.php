<?php
/**
 * Optimized version of matrix multiplication using pre-transposed matrix.
 *
 * @param array $m_a First matrix.
 * @param array $m_b Second matrix.
 * @return array Resulting matrix.
 * @throws InvalidArgumentException On invalid input.
 */
function optimized_matrix_mul(array $m_a, array $m_b): array {
    $rowsA = count($m_a);
    $colsA = count($m_a[0]);
    $colsB = count($m_b[0]);

    if (count($m_b) !== $colsA) {
        throw new InvalidArgumentException("Cannot multiply matrices");
    }

    // Transpose second matrix for better cache performance
    $transposedB = array_map(null, ...$m_b);

    $result = [];

    for ($i = 0; $i < $rowsA; $i++) {
        foreach ($transposedB as $colIdx => $col) {
            $sum = 0;
            foreach ($col as $rowIdx => $val) {
                $sum += $m_a[$i][$rowIdx] * $val;
            }
            $result[$i][$colIdx] = $sum;
        }
    }

    return $result;
}

// Example usage:
// print_r(optimized_matrix_mul([[1, 2], [3, 4]], [[5, 6], [7, 8]]));
?>
