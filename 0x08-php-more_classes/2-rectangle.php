<?php
/**
 * Class Rectangle - With string representation.
 */
class Rectangle {
    private $width;
    private $height;

    public function __construct($width = 0, $height = 0) {
        $this->width = $width;
        $this->height = $height;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setWidth($width) {
        if ($width <= 0) throw new Exception("Width must be positive.");
        $this->width = $width;
    }

    public function setHeight($height) {
        if ($height <= 0) throw new Exception("Height must be positive.");
        $this->height = $height;
    }

    public function area() {
        return $this->width * $this->height;
    }

    public function __toString() {
        return "Rectangle(width={$this->width}, height={$this->height})";
    }
}

// Example usage:
$rect = new Rectangle(3, 7);
echo $rect; // Output: Rectangle(width=3, height=7)
?>
