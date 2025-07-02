<?php
/**
 * Multiplies two matrices.
 *
 * @param array $m_a First matrix.
 * @param array $m_b Second matrix.
 * @return array Resulting matrix.
 * @throws InvalidArgumentException On invalid input.
 */
function matrix_mul(array $m_a, array $m_b): array {
    $rowsA = count($m_a);
    $colsA = count($m_a[0]);
    $rowsB = count($m_b);
    $colsB = count($m_b[0]);

    if ($colsA !== $rowsB) {
        throw new InvalidArgumentException("The columns of m_a must be equal to the rows of m_b");
    }

    $result = [];

    for ($i = 0; $i < $rowsA; $i++) {
        for ($j = 0; $j < $colsB; $j++) {
            $sum = 0;
            for ($k = 0; $k < $colsA; $k++) {
                $sum += $m_a[$i][$k] * $m_b[$k][$j];
            }
            $result[$i][$j] = $sum;
        }
    }

    return $result;
}

// Example usage:
// print_r(matrix_mul([[1, 2], [3, 4]], [[5, 6], [7, 8]]));
?>
