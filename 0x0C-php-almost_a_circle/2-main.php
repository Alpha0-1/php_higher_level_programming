<?php
require_once 'models/Rectangle.php';

try {
    $rect = new Rectangle(7, 3);
    echo "Width: " . $rect->getWidth() . "\n";
    echo "Height: " . $rect->getHeight() . "\n";
    echo "Area: " . $rect->area() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
