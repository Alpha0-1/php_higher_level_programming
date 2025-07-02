<?php
/**
 * Locked Class - Prevents adding new properties at runtime.
 */

class LockedClass {
    private $data = [];

    public function __construct() {
        $this->data['allowed_key'] = 'default';
    }

    public function __set($key, $value) {
        throw new Exception("Cannot add new property '$key'.");
    }

    public function __get($key) {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return null;
    }

    public function setValue($key, $value) {
        if (!array_key_exists($key, $this->data)) {
            throw new Exception("Key '$key' is not allowed.");
        }
        $this->data[$key] = $value;
    }
}

// Usage
$obj = new LockedClass();
$obj->setValue('allowed_key', 'new_value');
echo $obj->allowed_key . "\n";

try {
    $obj->disallowed_key = 'hack'; // Throws exception
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
