<!-- 3-rectangle.php -->
<?php
/**
 * Rectangle with Transformations
 * Adds rotation and scaling capabilities
 * @author Your Name
 * @license MIT
 */

class Rectangle {
    private $width;
    private $height;

    public function __construct($width, $height) {
        // Same validation...
    }

    // Existing getters and display method...

    /**
     * Rotate the rectangle by swapping dimensions
     */
    public function rotate() {
        list($this->width, $this->height) = [$this->height, $this->width];
    }

    /**
     * Double both dimensions
     */
    public function double() {
        $this->width *= 2;
        $this->height *= 2;
    }
}

// Example usage
$rect = new Rectangle(4, 2);
$rect->rotate();
$rect->double();
$rect->display();
