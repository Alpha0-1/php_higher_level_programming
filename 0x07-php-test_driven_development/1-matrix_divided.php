<?php
/**
 * Divides all elements of a matrix by a divisor.
 *
 * @param array $matrix A 2D array of numbers.
 * @param int|float $div Divisor.
 * @return array Resulting matrix.
 * @throws InvalidArgumentException For invalid input or division by zero.
 */
function matrix_divided(array $matrix, $div): array {
    if (!is_numeric($div)) {
        throw new InvalidArgumentException("Divisor must be a number");
    }

    if ($div === 0) {
        throw new InvalidArgumentException("division by zero");
    }

    $newMatrix = [];
    foreach ($matrix as $row) {
        if (!is_array($row)) {
            throw new InvalidArgumentException("Matrix must be a list of lists");
        }

        $newRow = [];
        foreach ($row as $element) {
            if (!is_numeric($element)) {
                throw new InvalidArgumentException("Matrix elements must be numbers");
            }
            $newRow[] = round($element / $div, 2);
        }
        $newMatrix[] = $newRow;
    }

    return $newMatrix;
}

// Example usage:
// print_r(matrix_divided([[1, 2], [3, 4]], 2));
// Output: [[0.5, 1], [1.5, 2]]
?>
