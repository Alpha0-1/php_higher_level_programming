<?php
/**
 * Rectangle - A class with input validation for dimensions.
 */
class Rectangle {
    private $width;
    private $height;

    /**
     * Constructor to initialize width and height with validation.
     *
     * @param int $width  Width of the rectangle.
     * @param int $height Height of the rectangle.
     * @throws Exception If invalid values are provided.
     */
    public function __construct($width, $height) {
        if (!is_int($width) || !is_int($height)) {
            throw new Exception("Width and height must be integers.");
        }
        if ($width <= 0 || $height <= 0) {
            throw new Exception("Width and height must be positive integers.");
        }
        $this->width = $width;
        $this->height = $height;
    }

    public function getWidth() { return $this->width; }
    public function getHeight() { return $this->height; }
}

// Example usage:
try {
    $rect = new Rectangle(5, 10);
    echo "Valid rectangle created.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
