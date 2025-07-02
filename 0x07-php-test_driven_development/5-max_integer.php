<?php
/**
 * Returns the largest integer in an array.
 *
 * @param array $list Array of integers.
 * @return int|null Largest integer or null if empty.
 * @throws InvalidArgumentException If any element is not integer.
 */
function max_integer(array $list): ?int {
    if (empty($list)) {
        return null;
    }

    foreach ($list as $item) {
        if (!is_int($item)) {
            throw new InvalidArgumentException("All elements must be integers");
        }
    }

    return max($list);
}

// Example usage:
// echo max_integer([1, 2, 3, 4]); // Output: 4
?>
