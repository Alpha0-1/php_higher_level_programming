<?php
/**
 * Lazily multiplies two matrices using generators.
 *
 * @param array $m_a First matrix.
 * @param array $m_b Second matrix.
 * @return \Generator Row-by-row results.
 * @throws InvalidArgumentException On invalid input.
 */
function lazy_matrix_mul(array $m_a, array $m_b): \Generator {
    $rowsA = count($m_a);
    $colsA = count($m_a[0]);
    $colsB = count($m_b[0]);

    if ($colsA !== count($m_b)) {
        throw new InvalidArgumentException("Cannot multiply matrices");
    }

    for ($i = 0; $i < $rowsA; $i++) {
        $row = [];
        for ($j = 0; $j < $colsB; $j++) {
            $sum = 0;
            for ($k = 0; $k < $colsA; $k++) {
                $sum += $m_a[$i][$k] * $m_b[$k][$j];
            }
            $row[] = $sum;
        }
        yield $row;
    }
}

// Example usage:
// foreach (lazy_matrix_mul([[1, 2], [3, 4]], [[5, 6], [7, 8]]) as $row) {
//     print_r($row);
// }
?>
