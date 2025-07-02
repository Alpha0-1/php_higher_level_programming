<?php
/**
 * MyInt - Integer that rebels by flipping equality.
 */
class MyInt extends IntVal {
    /**
     * == becomes !=
     * @param mixed $other
     * @return bool
     */
    public function __equals($other) {
        return !($this == $other);
    }

    /**
     * != becomes ==
     * @param mixed $other
     * @return bool
     */
    public function __notEquals($other) {
        return ($this == $other);
    }
}

// Usage Note: This is illustrative only, as PHP does not allow overriding operators directly.
// You would need to use wrapper classes or custom logic.

class RebelInt {
    private $value;

    public function __construct($value) {
        $this->value = $value;
    }

    public function __toString() {
        return (string)$this->value;
    }

    public function equals($other) {
        return $this->value != $other->value;
    }

    public function notEquals($other) {
        return $this->value == $other->value;
    }
}

// Example:
$a = new RebelInt(5);
$b = new RebelInt(5);

echo $a->equals($b) ? "True" : "False"; // False
echo "\n";
echo $a->notEquals($b) ? "True" : "False"; // True
?>
