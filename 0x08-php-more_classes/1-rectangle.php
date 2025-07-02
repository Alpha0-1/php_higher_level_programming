<?php
/**
 * Class Rectangle - With getter/setter methods.
 */
class Rectangle {
    private $width;
    private $height;

    public function getWidth() {
        return $this->width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setWidth($width) {
        if ($width > 0) {
            $this->width = $width;
        } else {
            throw new Exception("Width must be positive.");
        }
    }

    public function setHeight($height) {
        if ($height > 0) {
            $this->height = $height;
        } else {
            throw new Exception("Height must be positive.");
        }
    }

    public function area() {
        return $this->width * $this->height;
    }
}

// Example usage:
try {
    $rect = new Rectangle();
    $rect->setWidth(6);
    $rect->setHeight(4);
    echo "Area: " . $rect->area(); // Output: Area: 24
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
