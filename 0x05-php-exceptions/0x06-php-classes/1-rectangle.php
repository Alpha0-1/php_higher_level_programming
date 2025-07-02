<?php
/**
 * Rectangle - A class representing a rectangle.
 *
 * This version initializes width and height via constructor.
 */
class Rectangle {
    private $width;
    private $height;

    /**
     * Constructor to initialize width and height.
     *
     * @param int $width  Width of the rectangle.
     * @param int $height Height of the rectangle.
     */
    public function __construct($width, $height) {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Get the width of the rectangle.
     *
     * @return int
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * Get the height of the rectangle.
     *
     * @return int
     */
    public function getHeight() {
        return $this->height;
    }
}

// Example usage:
$rect = new Rectangle(5, 10);
echo "Width: " . $rect->getWidth() . "\n";

