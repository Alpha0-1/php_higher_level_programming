<?php
/**
 * Class Square - Extends Rectangle.
 */
class Square extends Rectangle {
    public function __construct($size = 0) {
        parent::__construct($size, $size);
    }
}

// Example usage:
$sq = new Square(5);
echo "Width: {$sq->getWidth()}, Height: {$sq->getHeight()}\n"; // 5, 5
?>
