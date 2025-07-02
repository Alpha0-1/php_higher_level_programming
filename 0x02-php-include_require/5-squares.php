<!-- 5-square.php -->
<?php
/**
 * Square Class
 * Extends Rectangle for square-specific functionality
 * @author Your Name
 * @license MIT
 */

require '4-rectangle.php';

class Square extends Rectangle {
    /**
     * Constructor
     * @param int $size Size of the square
     */
    public function __construct($size) {
        parent::__construct($size, $size);
    }

    /**
     * Create a new square instance
     * @param int $size Size of the square
     * @return Square New square instance
     */
    public static function square($size) {
        return new Square($size);
    }
}

// Example usage
$sq = new Square(3);
echo "Square size: " . $sq->getWidth() . "\n";
