<?php
require_once 'models/Square.php';

$square = new Square(5);
echo "Square Area: " . $square->area() . "\n";
echo "ID of square: " . $square->getId() . "\n";
?>
