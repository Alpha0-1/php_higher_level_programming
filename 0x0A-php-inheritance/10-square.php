<?php
require_once '9-rectangle.php';

/**
 * Square - Special case of Rectangle.
 */
class Square extends RectangleWithStr {
    /**
     * Constructor.
     * @param int $size Side length.
     */
    public function __construct($size) {
        parent::__construct($size, $size);
    }
}

// Example usage:
try {
    $square = new Square(5);
    echo $square; // Output: [Rectangle] 5/5
    echo "\nArea: " . $square->area(); // Output: Area: 25
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
