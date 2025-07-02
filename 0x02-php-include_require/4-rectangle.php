<!-- 4-rectangle.php -->
<?php
/**
 * Rectangle with Factory Method
 * Adds square creation capability
 * @author Your Name
 * @license MIT
 */

class Rectangle {
    // Existing properties and methods...

    /**
     * Create a square rectangle
     * @param int $size Size of the square
     * @return Rectangle New rectangle instance
     */
    public static function square($size) {
        return new Rectangle($size, $size);
    }
}

// Example usage
$square = Rectangle::square(5);
$square->display();
