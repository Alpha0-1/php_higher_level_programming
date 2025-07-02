<?php
require_once 'models/Rectangle.php';
require_once 'models/Square.php';

try {
    $rect = new Rectangle(8, 9);
    $square = new Square(8);

    echo "Rectangle Area: " . $rect->area() . "\n";
    echo "Square Area: " . $square->area() . "\n";

    if ($rect->area() === $square->area()) {
        echo "Same area!\n";
    } else {
        echo "Different areas.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
