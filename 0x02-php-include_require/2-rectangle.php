<!-- 2-rectangle.php -->
<?php
/**
 * Rectangle with Display Method
 * Adds visual representation of the rectangle
 * @author Your Name
 * @license MIT
 */

class Rectangle {
    private $width;
    private $height;

    public function __construct($width, $height) {
        // Same validation as 1-rectangle.php
    }

    // Same getters...

    /**
     * Display rectangle using asterisks
     */
    public function display() {
        for ($i = 0; $i < $this->height; $i++) {
            echo str_repeat('*', $this->width) . PHP_EOL;
        }
    }
}

// Example usage
$rect = new Rectangle(7, 3);
$rect->display();
