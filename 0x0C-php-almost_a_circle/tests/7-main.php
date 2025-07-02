<?php
require_once 'models/Rectangle.php';

try {
    $rect = new Rectangle(0, 5);
} catch (Exception $e) {
    echo "Expected error: " . $e->getMessage() . "\n";
}
?>
