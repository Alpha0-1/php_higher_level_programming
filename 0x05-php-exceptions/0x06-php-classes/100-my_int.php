<?php
/**
 * MyInt - A wrapper around integer with enhanced functionality.
 */
class MyInt {
    private $value;

    /**
     * Constructor to wrap an integer.
     *
     * @param int $value Integer value to store.
     * @throws Exception If value is not an integer.
     */
    public function __construct($value) {
        if (!is_int($value)) {
            throw new Exception("Value must be an integer.");
        }
        $this->value = $value;
    }

    /**
     * Returns the stored integer.
     *
     * @return int
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Adds another integer to this one.
     *
     * @param int $other Integer to add.
     * @return MyInt New instance with sum.
     */
    public function add($other) {
        if (!is_int($other)) {
            throw new Exception("Can only add integers.");
        }
        return new MyInt($this->value + $other);
    }
}

// Example usage:
try {
    $num = new MyInt(10);
    $sum = $num->add(5);
    echo "Result: " . $sum->getValue() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
