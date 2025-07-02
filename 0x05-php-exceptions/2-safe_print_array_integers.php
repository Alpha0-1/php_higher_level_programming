<?php
/**
 * 2-safe_print_array_integers.php - Safely print arrays of integers.
 *
 * Validates each element in the array before printing.
 */

function safePrintArrayIntegers($arr) {
    try {
        if (!is_array($arr)) {
            throw new Exception("Input must be an array.");
        }

        foreach ($arr as $val) {
            if (!is_int($val)) {
                throw new Exception("Element '$val' is not an integer.");
            }
            echo $val . "\n";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

// Example usage
safePrintArrayIntegers([1, 2, 3]);     // Prints 1, 2, 3
safePrintArrayIntegers([1, "two", 3]); // Fails on "two"
