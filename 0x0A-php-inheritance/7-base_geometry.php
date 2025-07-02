<?php
/**
 * BaseGeometry - With integer validator.
 */
abstract class BaseGeometry {
    /**
     * Validates that a value is a positive integer.
     * @param string $name Name of the attribute.
     * @param mixed $value Value to validate.
     * @throws Exception If invalid.
     */
    public function integer_validator($name, $value) {
        if (!is_int($value)) {
            throw new Exception("$name must be an integer");
        }
        if ($value <= 0) {
            throw new Exception("$name must be greater than 0");
        }
    }
}

// Example usage:
try {
    $bg = new class extends BaseGeometry {};
    $bg->integer_validator('width', -5); // Throws exception
} catch (Exception $e) {
    echo $e->getMessage(); // width must be greater than 0
}
?>
