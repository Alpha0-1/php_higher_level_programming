<?php
/**
 * Demonstrates Traits usage in PHP
 */

trait Loggable
{
    public function log(string $message): void
    {
        echo date('[Y-m-d H:i:s]') . " - $message\n";
    }
}

trait Timestampable
{
    private ?DateTime $createdAt = null;

    public function setCreatedAt(DateTime $date): void
    {
        $this->createdAt = $date;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }
}

class User
{
    use Loggable, Timestampable;

    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->setCreatedAt(new DateTime());
        $this->log("User $name created");
    }

    public function getName(): string
    {
        return $this->name;
    }
}

// Using class with traits
$user = new User('Alice');
echo "User created at: " . $user->getCreatedAt()->format('Y-m-d H:i:s') . "\n";

/**
 * Conflict resolution in traits
 */
trait FormatterA
{
    public function format(string $text): string
    {
        return "A: " . strtoupper($text);
    }
}

trait FormatterB
{
    public function format(string $text): string
    {
        return "B: " . strtolower($text);
    }
}

class TextProcessor
{
    use FormatterA, FormatterB {
        FormatterA::format insteadof FormatterB;
        FormatterB::format as formatB;
    }
}

$processor = new TextProcessor();
echo $processor->format('Hello World') . "\n"; // Uses FormatterA
echo $processor->formatB('Hello World') . "\n"; // Uses FormatterB

/**
 * Trait with abstract methods
 */
trait Validatable
{
    abstract public function validate(): bool;

    public function isValid(): bool
    {
        return $this->validate();
    }
}

class Product
{
    use Validatable;

    private float $price;

    public function __construct(float $price)
    {
        $this->price = $price;
    }

    public function validate(): bool
    {
        return $this->price > 0;
    }
}

$product = new Product(19.99);
echo "Product is " . ($product->isValid() ? 'valid' : 'invalid') . "\n";

/**
 * Changing method visibility
 */
trait SecretTrait
{
    private function secret(): string
    {
        return "Confidential information";
    }
}

class SecureContainer
{
    use SecretTrait {
        secret as public exposedSecret;
    }
}

$container = new SecureContainer();
echo $container->exposedSecret() . "\n"; // Now accessible
