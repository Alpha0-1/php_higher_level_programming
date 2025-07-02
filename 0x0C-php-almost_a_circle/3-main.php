<?php
require_once 'models/Square.php';

$square = new Square(4);
echo "Square Area: " . $square->area() . "\n";
echo "ID: " . $square->getId() . "\n";
?>
