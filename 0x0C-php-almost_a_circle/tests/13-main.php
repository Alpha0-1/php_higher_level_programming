<?php
require_once 'models/Rectangle.php';

try {
    $rect = new Rectangle("five", 10);
} catch (Exception $e) {
    echo "Expected error: " . $e->getMessage() . "\n";
}
?>
