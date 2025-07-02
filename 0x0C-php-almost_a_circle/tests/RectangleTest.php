<?php
require_once '../models/Rectangle.php';

class RectangleTest {
    public function run() {
        echo "Testing Rectangle Class:\n";

        try {
            $rect = new Rectangle(5, 10);
            echo "Area of rectangle (5x10): " . $rect->area() . "\n";
            echo "Width: " . $rect->getWidth() . ", Height: " . $rect->getHeight() . "\n";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }

        try {
            $badRect = new Rectangle(-3, 4); // Invalid input
        } catch (Exception $e) {
            echo "Expected error: " . $e->getMessage() . "\n";
        }
    }
}

$test = new RectangleTest();
$test->run();
?>
