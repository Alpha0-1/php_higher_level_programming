<?php
/**
 * Demonstrates common design patterns in PHP
 */

/**
 * Singleton Pattern
 */
final class DatabaseConnection
{
    private static ?self $instance = null;
    private static string $connection;

    // Private constructor to prevent direct instantiation
    private function __construct()
    {
        self::$connection = "Connected to database";
    }

    // Prevent cloning
    private function __clone() {}

    // Prevent unserialization
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): string
    {
        return self::$connection;
    }
}

// Usage
$db1 = DatabaseConnection::getInstance();
$db2 = DatabaseConnection::getInstance();

echo $db1 === $db2 ? "Same instance" : "Different instances"; // Output: Same instance

/**
 * Factory Pattern
 */
interface PaymentMethod
{
    public function pay(float $amount): string;
}

class CreditCardPayment implements PaymentMethod
{
    public function pay(float $amount): string
    {
        return "Paid $amount via Credit Card";
    }
}

class PayPalPayment implements PaymentMethod
{
    public function pay(float $amount): string
    {
        return "Paid $amount via PayPal";
    }
}

class PaymentFactory
{
    public static function create(string $type): PaymentMethod
    {
        return match (strtolower($type)) {
            'creditcard' => new CreditCardPayment(),
            'paypal' => new PayPalPayment(),
            default => throw new InvalidArgumentException("Invalid payment method"),
        };
    }
}

// Usage
$payment = PaymentFactory::create('creditcard');
echo $payment->pay(100.50);

/**
 * Observer Pattern
 */
interface Observer
{
    public function update(string $eventData): void;
}

class UserNotifier implements Observer
{
    public function update(string $eventData): void
    {
        echo "Sending notification: $eventData\n";
    }
}

class EventLogger implements Observer
{
    public function update(string $eventData): void
    {
        echo "Logging event: $eventData\n";
    }
}

class EventManager
{
    private array $observers = [];

    public function attach(Observer $observer): void
    {
        $this->observers[] = $observer;
    }

    public function notify(string $eventData): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($eventData);
        }
    }
}

// Usage
$eventManager = new EventManager();
$eventManager->attach(new UserNotifier());
$eventManager->attach(new EventLogger());

$eventManager->notify("User logged in");
