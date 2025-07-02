<?php
/**
 * Class Square - With position handling.
 */
class Square extends Rectangle {
    private $x = 0;
    private $y = 0;

    public function move($x, $y) {
        $this->x = $x;
        $this->y = $y;
    }

    public function getPosition() {
        return ["x" => $this->x, "y" => $this->y];
    }
}

// Example usage:
$sq = new Square(3);
$sq->move(10, 20);
print_r($sq->getPosition()); // Array ( [x] => 10 [y] => 20 )
?>
