<?php
/**
 * 1-safe_print_integer.php - Safely print integers.
 *
 * Ensures only valid integers are printed; otherwise, catches exceptions.
 */

function safePrintInteger($value) {
    try {
        if (!is_int($value)) {
            throw new Exception("Value is not an integer.");
        }
        echo $value . "\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

// Example usage
safePrintInteger(42);      // Should print 42
safePrintInteger("42");    // Triggers exception
