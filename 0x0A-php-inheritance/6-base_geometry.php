<?php
/**
 * BaseGeometry - Abstract base class with area method.
 */
abstract class BaseGeometry {
    /**
     * Calculates the area (to be implemented by subclasses).
     * @throws Exception If not implemented.
     */
    public function area() {
        throw new Exception("area() is not implemented");
    }
}

// Example usage:
try {
    $bg = new class extends BaseGeometry {};
    $bg->area();
} catch (Exception $e) {
    echo $e->getMessage(); // Outputs: area() is not implemented
}
?>
