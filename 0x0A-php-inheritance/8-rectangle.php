<?php
require_once '7-base_geometry.php';

/**
 * Rectangle - Inherits from BaseGeometry.
 */
class Rectangle extends BaseGeometry {
    protected $width;
    protected $height;

    /**
     * Constructor.
     * @param int $width Width of rectangle.
     * @param int $height Height of rectangle.
     */
    public function __construct($width, $height) {
        $this->integer_validator('width', $width);
        $this->integer_validator('height', $height);
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Calculates area.
     * @return int Area.
     */
    public function area() {
        return $this->width * $this->height;
    }
}

// Example usage:
try {
    $rect = new Rectangle(3, 4);
    echo "Area: " . $rect->area(); // Output: Area: 12
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
