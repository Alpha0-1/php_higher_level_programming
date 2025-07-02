<?php
require_once '10-square.php';

/**
 * SquareWithStr - Adds a custom string representation to the Square class.
 */
class SquareWithStr extends Square {
    /**
     * Returns the string representation of the square.
     *
     * @return string
     */
    public function __toString() {
        return "[Square] {$this->width}/{$this->height}";
    }
}

// Example usage:
try {
    $square = new SquareWithStr(7);
    echo $square; // Output: [Square] 7/7
    echo "\nArea: " . $square->area(); // Output: Area: 49
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
