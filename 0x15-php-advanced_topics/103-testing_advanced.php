<?php
/**
 * Demonstrates advanced testing techniques in PHP
 * 
 * Note: Requires PHPUnit (composer require --dev phpunit/phpunit)
 */

// Class to test
class ShoppingCart
{
    private array $items = [];
    private PaymentProcessor $paymentProcessor;

    public function __construct(PaymentProcessor $paymentProcessor)
    {
        $this->paymentProcessor = $paymentProcessor;
    }

    public function addItem(string $item, float $price): void
    {
        $this->items[$item] = $price;
    }

    public function removeItem(string $item): void
    {
        if (!isset($this->items[$item])) {
            throw new InvalidArgumentException("Item $item not in cart");
        }
        unset($this->items[$item]);
    }

    public function getTotal(): float
    {
        return array_sum($this->items);
    }

    public function checkout(string $paymentMethod): bool
    {
        $total = $this->getTotal();
        if ($total <= 0) {
            throw new RuntimeException("Cannot checkout with empty cart");
        }

        return $this->paymentProcessor->processPayment($paymentMethod, $total);
    }

    public function getItems(): array
    {
        return $this->items;
    }
}

interface PaymentProcessor
{
    public function processPayment(string $method, float $amount): bool;
}

/**
 * PHPUnit tests would typically be in a separate file
 * Here's an example of what the test class might look like:
 * 
 * use PHPUnit\Framework\TestCase;
 * 
 * class ShoppingCartTest extends TestCase
 * {
 *     // Test cases would go here
 * }
 */

/**
 * Mocking examples
 */
class MockPaymentProcessor implements PaymentProcessor
{
    private bool $shouldSucceed;

    public function __construct(bool $shouldSucceed = true)
    {
        $this->shouldSucceed = $shouldSucceed;
    }

    public function processPayment(string $method, float $amount): bool
    {
        return $this->shouldSucceed;
    }
}

// Manual mock usage example
$successProcessor = new MockPaymentProcessor(true);
$failProcessor = new MockPaymentProcessor(false);

$cart = new ShoppingCart($successProcessor);
$cart->addItem('Book', 19.99);
echo "Checkout with success processor: " . ($cart->checkout('credit_card') ? 'Success' : 'Fail') . "\n";

$cart = new ShoppingCart($failProcessor);
$cart->addItem('Book', 19.99);
echo "Checkout with fail processor: " . ($cart->checkout('credit_card') ? 'Success' : 'Fail') . "\n";

/**
 * Data provider example (how it would look in PHPUnit)
 * 
 * public function cartTotalProvider(): array
 * {
 *     return [
 *         [['Book' => 19.99], 19.99],
 *         [['Book' => 19.99, 'Movie' => 9.99], 29.98],
 *         [[], 0]
 *     ];
 * }
 * 
 * /**
 *  * @dataProvider cartTotalProvider
 *  * /
 * public function testGetTotal(array $items, float $expectedTotal): void
 * {
 *     $processor = $this->createMock(PaymentProcessor::class);
 *     $cart = new ShoppingCart($processor);
 *     
 *     foreach ($items as $item => $price) {
 *         $cart->addItem($item, $price);
 *     }
 *     
 *     $this->assertEquals($expectedTotal, $cart->getTotal());
 * }
 */

/**
 * Testing exceptions example
 */
try {
    $processor = new MockPaymentProcessor();
    $cart = new ShoppingCart($processor);
    $cart->removeItem('NonExistent');
    echo "Exception not thrown for invalid item\n";
} catch (InvalidArgumentException $e) {
    echo "Caught expected exception: " . $e->getMessage() . "\n";
}

/**
 * Integration test example
 */
class RealPaymentProcessor implements PaymentProcessor
{
    public function processPayment(string $method, float $amount): bool
    {
        // Simulate actual payment processing
        if ($amount <= 0) {
            throw new InvalidArgumentException("Amount must be positive");
        }

        // In a real implementation, this would call a payment gateway
        return true;
    }
}

// Integration test
$processor = new RealPaymentProcessor();
$cart = new ShoppingCart($processor);
$cart->addItem('Laptop', 999.99);
echo "Integration test result: " . ($cart->checkout('paypal') ? 'Success' : 'Fail') . "\n";

/**
 * Test doubles example
 */
class TestableShoppingCart extends ShoppingCart
{
    public function getPaymentProcessor(): PaymentProcessor
    {
        return $this->paymentProcessor;
    }
}

// Testing protected/private aspects via test double
$processor = new MockPaymentProcessor();
$cart = new TestableShoppingCart($processor);
echo "Test double verification: " . 
    ($cart->getPaymentProcessor() === $processor ? 'Success' : 'Fail') . "\n";

/**
 * Performance testing example
 */
function timeOperation(callable $operation, int $iterations = 1000): float
{
    $start = microtime(true);
    for ($i = 0; $i < $iterations; $i++) {
        $operation();
    }
    return microtime(true) - $start;
}

$processor = new MockPaymentProcessor();
$cart = new ShoppingCart($processor);
$cart->addItem('Test', 1.00);

$time = timeOperation(fn() => $cart->checkout('credit_card'));
echo "Operation took " . number_format($time * 1000, 2) . "ms for 1000 iterations\n";
