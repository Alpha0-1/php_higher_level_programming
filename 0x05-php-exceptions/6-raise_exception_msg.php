<?php
/**
 * 6-raise_exception_msg.php - Raise exception with message.
 *
 * Throws a custom exception with a detailed message.
 */

class ValidationException extends Exception {}

try {
    throw new ValidationException("Validation failed: missing field 'username'.");
} catch (ValidationException $e) {
    echo "Caught validation error: " . $e->getMessage() . "\n";
}
