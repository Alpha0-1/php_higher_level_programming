<?php
require_once 'Rectangle.php';

/**
 * Square class extending Rectangle.
 */
class Square extends Rectangle {
    /**
     * Constructor that sets both width and height to the same value.
     *
     * @param int $size
     */
    public function __construct($size) {
        parent::__construct($size, $size);
    }

    /**
     * Overriding getWidth to reflect square property.
     *
     * @return int
     */
    public function getWidth() {
        return parent::getWidth(); // Same as height
    }

    /**
     * Overriding getHeight to reflect square property.
     *
     * @return int
     */
    public function getHeight() {
        return parent::getHeight(); // Same as width
    }
}
?>
