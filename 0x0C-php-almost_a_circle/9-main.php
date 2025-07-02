<?php
require_once 'models/Rectangle.php';

try {
    $rect = new Rectangle(-3, 4);
} catch (Exception $e) {
    echo "Expected error: " . $e->getMessage() . "\n";
}
?>
