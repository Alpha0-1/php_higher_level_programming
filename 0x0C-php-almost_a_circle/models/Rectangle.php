<?php
require_once 'Base.php';

/**
 * Rectangle class representing a rectangle shape.
 */
class Rectangle extends Base {
    /**
     * @var int Width of the rectangle.
     */
    private $width;

    /**
     * @var int Height of the rectangle.
     */
    private $height;

    /**
     * Constructor to initialize width and height.
     *
     * @param int $width
     * @param int $height
     * @throws Exception if dimensions are not positive integers.
     */
    public function __construct($width, $height) {
        parent::__construct();

        if (!is_int($width) || !is_int($height) || $width <= 0 || $height <= 0) {
            throw new Exception("Width and height must be positive integers.");
        }

        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Get the width of the rectangle.
     *
     * @return int
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * Get the height of the rectangle.
     *
     * @return int
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * Calculate the area of the rectangle.
     *
     * @return int
     */
    public function area() {
        return $this->width * $this->height;
    }
}
?>
