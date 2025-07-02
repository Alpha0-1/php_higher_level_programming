<?php
/**
 * Class Square - With custom display character.
 */
class Square extends Rectangle {
    private $char = "*";

    public function setChar($char) {
        $this->char = $char;
    }

    public function display() {
        for ($i = 0; $i < $this->getHeight(); $i++) {
            echo str_repeat($this->char, $this->getWidth()) . "\n";
        }
    }
}

// Example usage:
$sq = new Square(4);
$sq->setChar("#");
$sq->display();
// Output:
// ####
// ####
// ####
// ####
?>
