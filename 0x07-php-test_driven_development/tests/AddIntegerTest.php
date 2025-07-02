<?php
use PHPUnit\Framework\TestCase;

class AddIntegerTest extends TestCase {
    public function testAddIntegers() {
        $this->assertEquals(5, add_integer(2, 3));
    }

    public function testAddFloats() {
        $this->assertEquals(5, add_integer(2.7, 3.1));
    }

    public function testInvalidInputs() {
        $this->expectException(TypeError::class);
        add_integer("two", 3);
    }
}
?>
