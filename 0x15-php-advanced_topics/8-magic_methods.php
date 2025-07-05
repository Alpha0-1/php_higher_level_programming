<?php
/**
 * Demonstrates PHP magic methods
 */

class MagicDemo
{
    private array $data = [];
    private array $accessedProperties = [];

    // Called when accessing inaccessible properties
    public function __get(string $name): mixed
    {
        echo "Getting property '$name'\n";
        $this->accessedProperties[$name] = true;
        return $this->data[$name] ?? null;
    }

    // Called when setting inaccessible properties
    public function __set(string $name, mixed $value): void
    {
        echo "Setting property '$name' to '$value'\n";
        $this->data[$name] = $value;
    }

    // Called when isset() or empty() is called on inaccessible properties
    public function __isset(string $name): bool
    {
        echo "Checking if '$name' is set\n";
        return isset($this->data[$name]);
    }

    // Called when unset() is called on inaccessible properties
    public function __unset(string $name): void
    {
        echo "Unsetting property '$name'\n";
        unset($this->data[$name]);
    }

    // Called when invoking inaccessible methods
    public function __call(string $name, array $arguments): mixed
    {
        echo "Calling method '$name' with arguments: " . implode(', ', $arguments) . "\n";
        $method = 'do_' . strtolower($name);
        if (method_exists($this, $method)) {
            return $this->$method(...$arguments);
        }
        throw new BadMethodCallException("Method $name doesn't exist");
    }

    // Called when invoking inaccessible methods in static context
    public static function __callStatic(string $name, array $arguments): mixed
    {
        echo "Calling static method '$name' with arguments: " . implode(', ', $arguments) . "\n";
        return "Result from $name";
    }

    // Called when object is treated as a string
    public function __toString(): string
    {
        return "MagicDemo object with data: " . json_encode($this->data);
    }

    // Called when object is called as a function
    public function __invoke(...$args): mixed
    {
        return "Object invoked with args: " . implode(', ', $args);
    }

    // Called during serialization
    public function __sleep(): array
    {
        echo "Preparing for serialization\n";
        return ['data']; // Only serialize these properties
    }

    // Called during unserialization
    public function __wakeup(): void
    {
        echo "Waking up from serialization\n";
        $this->accessedProperties = [];
    }

    // Called when cloning the object
    public function __clone(): void
    {
        echo "Cloning the object\n";
        $this->data = array_map(fn($item) => is_object($item) ? clone $item : $item, $this->data);
    }

    // Called when var_dump() is called on the object
    public function __debugInfo(): array
    {
        return [
            'data' => $this->data,
            'accessed_properties' => array_keys($this->accessedProperties)
        ];
    }

    private function do_calculate(int $a, int $b): int
    {
        return $a + $b;
    }
}

// Demonstrate magic methods
$magic = new MagicDemo();

// __set and __get
$magic->name = 'Alice';
echo $magic->name . "\n";

// __isset and __unset
echo isset($magic->name) ? "Name is set\n" : "Name is not set\n";
unset($magic->name);
echo isset($magic->name) ? "Name is set\n" : "Name is not set\n";

// __call
echo $magic->calculate(5, 3) . "\n";

// __callStatic
echo MagicDemo::staticMethod('test') . "\n";

// __toString
echo $magic . "\n";

// __invoke
echo $magic(1, 2, 3) . "\n";

// __debugInfo
var_dump($magic);

// __clone
$clone = clone $magic;
