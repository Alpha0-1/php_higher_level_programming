<?php
/**
 * Class Rectangle - With rotate and double methods.
 */
class Rectangle {
    private $width;
    private $height;

    public function __construct($width = 0, $height = 0) {
        $this->width = $width;
        $this->height = $height;
    }

    public function getWidth() { return $this->width; }
    public function getHeight() { return $this->height; }

    public function setWidth($width) {
        if ($width <= 0) throw new Exception("Width must be positive.");
        $this->width = $width;
    }

    public function setHeight($height) {
        if ($height <= 0) throw new Exception("Height must be positive.");
        $this->height = $height;
    }

    public function area() { return $this->width * $this->height; }

    public function rotate() {
        [$this->width, $this->height] = [$this->height, $this->width];
    }

    public function double() {
        $this->width *= 2;
        $this->height *= 2;
    }
}

// Example usage:
$rect = new Rectangle(2, 4);
echo "Original dimensions: {$rect->getWidth()} x {$rect->getHeight()}\n"; // 2 x 4

$rect->rotate();
echo "After rotation: {$rect->getWidth()} x {$rect->getHeight()}\n"; // 4 x 2

$rect->double();
echo "After doubling: {$rect->getWidth()} x {$rect->getHeight()}\n"; // 8 x 4
?>
