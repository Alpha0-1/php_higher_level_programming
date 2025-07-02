<?php
require_once '8-rectangle.php';

/**
 * RectangleWithStr - Adds string representation.
 */
class RectangleWithStr extends Rectangle {
    /**
     * String representation.
     * @return string Description.
     */
    public function __toString() {
        return "[Rectangle] {$this->width}/{$this->height}";
    }
}

// Example usage:
try {
    $rect = new RectangleWithStr(5, 10);
    echo $rect; // Output: [Rectangle] 5/10
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
