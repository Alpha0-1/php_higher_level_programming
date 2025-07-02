<!-- 0-rectangle.php -->
<?php
/**
 * Rectangle Class
 * Represents a basic rectangle with width and height
 * @author Your Name
 * @license MIT
 */

class Rectangle {
    private $width;
    private $height;

    /**
     * Constructor
     * @param int $width Width of the rectangle
     * @param int $height Height of the rectangle
     */
    public function __construct($width, $height) {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Get width
     * @return int
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * Get height
     * @return int
     */
    public function getHeight() {
        return $this->height;
    }
}

// Example usage
$rect = new Rectangle(5, 10);
echo "Width: " . $rect->getWidth() . "\n";
echo "Height: " . $rect->getHeight() . "\n";
