<?php
require_once 'models/Base.php';

// Anonymous class extending Base
$obj1 = new class extends Base {
    public function area() { return 0; }
};

// Another anonymous class instance
$obj2 = new class extends Base {
    public function area() { return 0; }
};

echo "Object 1 ID: " . $obj1->getId() . "\n";
echo "Object 2 ID: " . $obj2->getId() . "\n";
?>
