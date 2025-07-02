<?php
/**
 * Rectangle - Adds rotate and double methods.
 */
class Rectangle {
    private $width;
    private $height;

    public function __construct($width, $height) {
        if (!is_int($width) || !is_int($height) || $width <= 0 || $height <= 0) {
            throw new Exception("Width and height must be positive integers.");
        }
        $this->width = $width;
        $this->height = $height;
    }

    public function getWidth() { return $this->width; }
    public function getHeight() { return $this->height; }

    /**
     * Rotates the rectangle by swapping width and height.
     */
    public function rotate() {
        list($this->width, $this->height) = [$this->height, $this->width];
    }

    /**
     * Doubles the size of the rectangle.
     */
    public function double() {
        $this->width *= 2;
        $this->height *= 2;
    }
}

// Example usage:
try {
    $rect = new Rectangle(2, 4);
    echo "Original: {$rect->getWidth()} x {$rect->getHeight()}\n";

    $rect->rotate();
    echo "After rotate: {$rect->getWidth()} x {$rect->getHeight()}\n";

    $rect->double();
    echo "After doubling: {$rect->getWidth()} x {$rect->getHeight()}\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
