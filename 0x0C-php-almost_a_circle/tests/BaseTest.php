<?php
require_once '../models/Base.php';

class BaseTest {
    public function run() {
        echo "Testing Base Class:\n";

        $b1 = new class extends Base {
            public function area() { return 0; }
        };
        $b2 = new class extends Base {
            public function area() { return 0; }
        };

        echo "ID of b1: " . $b1->getId() . "\n"; // Expected: 1
        echo "ID of b2: " . $b2->getId() . "\n"; // Expected: 2
    }
}

$test = new BaseTest();
$test->run();
?>
