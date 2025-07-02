<?php
/**
 * Prints a square made of '#'.
 *
 * @param int $size Side length of the square.
 * @return void
 * @throws InvalidArgumentException If size is not a positive integer.
 */
function print_square(int $size): void {
    if (!is_int($size) || $size <= 0) {
        throw new InvalidArgumentException("Size must be a positive integer");
    }

    for ($i = 0; $i < $size; $i++) {
        echo str_repeat('#', $size) . "\n";
    }
}

// Example usage:
// print_square(4);
// Output:
// ####
// ####
// ####
// ####
?>
