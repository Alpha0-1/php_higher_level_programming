<?php
require_once 'models/Rectangle.php';

try {
    $rect1 = new Rectangle(2, 3);
    $rect2 = new Rectangle(4, 5);

    echo "Rectangle 1 ID: " . $rect1->getId() . "\n";
    echo "Rectangle 2 ID: " . $rect2->getId() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
