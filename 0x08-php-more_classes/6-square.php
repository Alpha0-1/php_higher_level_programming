<?php
/**
 * Class Square - With size getter/setter.
 */
class Square extends Rectangle {
    public function getSize() {
        return $this->getWidth();
    }

    public function setSize($size) {
        $this->setWidth($size);
        $this->setHeight($size);
    }
}

// Example usage:
$sq = new Square(3);
echo "Size: {$sq->getSize()}\n"; // 3

$sq->setSize(6);
echo "New Size: {$sq->getSize()}\n"; // 6
?>
