<?php

/**
 * 102-add_me_maybe.php
 *
 * This file defines a function that conditionally executes another function
 * based on whether it receives an integer argument.
 *
 * Usage:
 *   Call addMeMaybe() with or without an integer to see how it behaves.
 */

/**
 * Adds one to the given number if it is an integer.
 * Otherwise, prints a message indicating no valid input.
 *
 * @param mixed $num The input value to be checked and incremented.
 */
function addMeMaybe($num) {
    if (is_int($num)) {
        echo $num + 1 . PHP_EOL;
    } else {
        echo "No valid integer provided." . PHP_EOL;
    }
}

// Example test calls
addMeMaybe(5);       // Should output: 6
addMeMaybe("hello"); // Should output: No valid integer provided.
