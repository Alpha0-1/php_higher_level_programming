<?php
require_once 'models/Rectangle.php';
require_once 'models/Square.php';

try {
    $rect = new Rectangle(10, 20);
    $square = new Square(15);

    echo "Rectangle Width: " . $rect->getWidth() . "\n";
    echo "Rectangle Height: " . $rect->getHeight() . "\n";
    echo "Square Size: " . $square->getWidth() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
