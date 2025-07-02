<?php
require_once 'models/Rectangle.php';

try {
    $rect = new Rectangle(4, -3);
} catch (Exception $e) {
    echo "Expected error: " . $e->getMessage() . "\n";
}
?>
