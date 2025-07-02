<?php
/**
 * 102-magic_calculation.php - Magic calculation with exceptions.
 *
 * Simulates a complex operation with possible failures.
 */

function magicCalculation($a, $b) {
    try {
        if ($a < 0 || $b < 0) {
            throw new Exception("Negative numbers not allowed.");
        }
        if ($a + $b > 100) {
            throw new Exception("Sum exceeds maximum allowed value (100).");
        }
        return sqrt($a * $b);
    } catch (Exception $e) {
        echo "Magic error: " . $e->getMessage() . "\n";
        return null;
    }
}

// Example usage
echo magicCalculation(5, 10) . "\n";       // Valid
echo magicCalculation(-1, 5) . "\n";       // Negative input
echo magicCalculation(90, 20) . "\n";      // Sum too large
