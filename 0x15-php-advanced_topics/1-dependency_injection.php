<?php
/**
 * Demonstrates Dependency Injection in PHP
 */

interface LoggerInterface
{
    public function log(string $message): void;
}

class FileLogger implements LoggerInterface
{
    public function log(string $message): void
    {
        file_put_contents('app.log', date('Y-m-d H:i:s') . " - $message\n", FILE_APPEND);
    }
}

class DatabaseLogger implements LoggerInterface
{
    public function log(string $message): void
    {
        // Simulate database logging
        echo "Logged to database: $message\n";
    }
}

class UserService
{
    private LoggerInterface $logger;

    // Constructor injection
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function registerUser(string $username): void
    {
        // User registration logic...
        $this->logger->log("User registered: $username");
    }

    // Setter injection
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}

// Usage with constructor injection
$fileLogger = new FileLogger();
$userService = new UserService($fileLogger);
$userService->registerUser('john_doe');

// Changing logger using setter injection
$dbLogger = new DatabaseLogger();
$userService->setLogger($dbLogger);
$userService->registerUser('jane_doe');

/**
 * Dependency Injection Container example
 */
class Container
{
    private array $services = [];

    public function register(string $name, callable $resolver): void
    {
        $this->services[$name] = $resolver;
    }

    public function resolve(string $name): mixed
    {
        if (!isset($this->services[$name])) {
            throw new RuntimeException("Service $name not found");
        }
        return $this->services[$name]($this);
    }
}

// Configure the container
$container = new Container();
$container->register('logger', function() {
    return new FileLogger();
});
$container->register('userService', function(Container $c) {
    return new UserService($c->resolve('logger'));
});

// Get service from container
$userService = $container->resolve('userService');
$userService->registerUser('container_user');
