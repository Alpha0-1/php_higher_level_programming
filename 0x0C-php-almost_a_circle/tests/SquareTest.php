<?php
require_once '../models/Square.php';

class SquareTest {
    public function run() {
        echo "Testing Square Class:\n";

        $square = new Square(7);
        echo "Area of square (7x7): " . $square->area() . "\n";
        echo "Width: " . $square->getWidth() . ", Height: " . $square->getHeight() . "\n";
    }
}

$test = new SquareTest();
$test->run();
?>
