<!-- 100-map.php -->
<?php
/**
 * Map Implementation
 * Simple associative array-based map
 * @author Your Name
 * @license MIT
 */

class Map {
    private $data = [];

    public function set($key, $value) {
        $this->data[$key] = $value;
    }

    public function get($key) {
        return $this->data[$key] ?? null;
    }

    public function delete($key) {
        unset($this->data[$key]);
    }

    public function getAll() {
        return $this->data;
    }
}

// Example usage
$userMap = new Map();
$userMap->set('name', 'Alice');
$userMap->set('age', 30);
echo "Name: " . $userMap->get('name') . "\n";
$userMap->delete('age');
print_r($userMap->getAll());
