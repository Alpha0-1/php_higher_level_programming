<?php
/**
 * 103-custom_exceptions.php - Define and use custom exception classes.
 *
 * Shows how to create and use multiple custom exception types.
 */

class InputTooShortException extends Exception {}
class InputTooLongException extends Exception {}

function validateStringLength($str, $min, $max) {
    $len = strlen($str);
    if ($len < $min) {
        throw new InputTooShortException("String is too short. Minimum length: $min");
    }
    if ($len > $max) {
        throw new InputTooLongException("String is too long. Maximum length: $max");
    }
    echo "String is valid.\n";
}

// Example usage
try {
    validateStringLength("PHP", 2, 10);         // Valid
    validateStringLength("P", 2, 10);           // Too short
} catch (InputTooShortException $e) {
    echo "Input error: " . $e->getMessage() . "\n";
}

try {
    validateStringLength("A very long string indeed!", 2, 10); // Too long
} catch (InputTooLongException $e) {
    echo "Input error: " . $e->getMessage() . "\n";
}
