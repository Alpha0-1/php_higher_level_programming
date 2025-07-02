<?php
/**
 * Square - A subclass of Rectangle.
 *
 * Ensures both width and height are equal.
 */
class Square extends Rectangle {
    /**
     * Constructor to create a square.
     *
     * @param int $size The size of both sides.
     */
    public function __construct($size) {
        parent::__construct($size, $size);
    }
}

// Example usage:
try {
    $square = new Square(5);
    echo "Square: {$square->getWidth()} x {$square->getHeight()}\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
