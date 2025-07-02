<?php
/**
 * 3-safe_print_division.php - Safely perform division.
 *
 * Handles division by zero and non-numeric inputs.
 */

function safeDivision($numerator, $denominator) {
    try {
        if (!is_numeric($numerator) || !is_numeric($denominator)) {
            throw new Exception("Both values must be numeric.");
        }
        if ($denominator == 0) {
            throw new Exception("Cannot divide by zero.");
        }
        echo "Result: " . ($numerator / $denominator) . "\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

// Example usage
safeDivision(10, 2);   // Result: 5
safeDivision(10, 0);   // Error: Cannot divide by zero
safeDivision("ten", 2); // Error: Both values must be numeric
