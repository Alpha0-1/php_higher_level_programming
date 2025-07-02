<?php
/**
 * Adds two integers or floats and returns an integer result.
 *
 * @param int|float $a First number.
 * @param int|float $b Second number.
 * @return int Sum as integer.
 * @throws TypeError If inputs are not int or float.
 */
function add_integer($a, $b): int {
    if (!is_numeric($a) || !is_numeric($b)) {
        throw new TypeError("Both arguments must be numbers");
    }

    return (int)($a + $b);
}

// Example usage:
// echo add_integer(2, 3); // Output: 5
?>
