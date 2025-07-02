<?php
/**
 * Square - With a custom character display.
 */
class Square extends Rectangle {
    private $char = '*';

    public function __construct($size) {
        parent::__construct($size, $size);
    }

    /**
     * Sets the character used for display.
     *
     * @param string $char Character to use for drawing.
     */
    public function setChar($char) {
        $this->char = $char;
    }

    /**
     * Displays the square using a specified character.
     */
    public function display() {
        for ($i = 0; $i < $this->getHeight(); $i++) {
            echo str_repeat($this->char, $this->getWidth()) . "\n";
        }
    }
}

// Example usage:
try {
    $square = new Square(4);
    $square->setChar('#');
    $square->display();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();

