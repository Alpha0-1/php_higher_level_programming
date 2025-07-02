<?php
/**
 * Class Square - Comparison with other squares.
 */
class Square extends Rectangle {
    public function equals(Square $other) {
        return $this->getSize() === $other->getSize();
    }

    public function greaterThan(Square $other) {
        return $this->getSize() > $other->getSize();
    }

    public function lessThan(Square $other) {
        return $this->getSize() < $other->getSize();
    }
}

// Example usage:
$sq1 = new Square(5);
$sq2 = new Square(7);

echo $sq1->equals($sq2) ? "Equal\n" : "Not equal\n";      // Not equal
echo $sq1->greaterThan($sq2) ? "Larger\n" : "Smaller\n";  // Smaller
echo $sq1->lessThan($sq2) ? "Smaller\n" : "Larger\n";     // Smaller
?>
