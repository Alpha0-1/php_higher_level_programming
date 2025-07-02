<!-- 6-square.php -->
<?php
/**
 * Square with Character Display
 * Adds custom character rendering
 * @author Your Name
 * @license MIT
 */

require '5-square.php';

class Square extends \Square {
    /**
     * Display square using specified character
     * @param string $char Character to use for display
     */
    public function displayChar($char = '#') {
        for ($i = 0; $i < $this->getHeight(); $i++) {
            echo str_repeat($char, $this->getWidth()) . PHP_EOL;
        }
    }
}

// Example usage
$sq = new Square(4);
$sq->displayChar('@');
