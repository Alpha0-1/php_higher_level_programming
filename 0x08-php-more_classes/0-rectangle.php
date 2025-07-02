<?php
/**
 * Class Rectangle - Represents a basic rectangle.
 */
class Rectangle {
    protected $width;
    protected $height;

    public function __construct($width = 0, $height = 0) {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Calculates area of the rectangle.
     *
     * @return int Area
     */
    public function area() {
        return $this->width * $this->height;
    }
}

// Example usage:
$rect = new Rectangle(5, 10);
echo "Area: " . $rect->area(); // Output: Area: 50
?>
