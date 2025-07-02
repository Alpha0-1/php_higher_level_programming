<?php
/**
 * Rectangle - With a display method that prints the rectangle as asterisks.
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

    /**
     * Displays the rectangle using asterisks.
     */
    public function display() {
        for ($i = 0; $i < $this->height; $i++) {
            echo str_repeat('*', $this->width) . "\n";
        }
    }
}

// Example usage:
try {
    $rect = new Rectangle(4, 3);
    $rect->display();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
