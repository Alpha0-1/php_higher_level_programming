<?php
/**
 * Demonstrates Microservices architecture with PHP
 */

/**
 * Service Discovery Client
 */
class ServiceDiscovery
{
    private string $discoveryUrl;

    public function __construct(string $discoveryUrl)
    {
        $this->discoveryUrl = $discoveryUrl;
    }

    public function getServiceUrl(string $serviceName): string
    {
        // In a real implementation, this would call the discovery service
        // For demo, we'll return mock URLs
        $services = [
            'user' => 'http://user-service.local',
            'order' => 'http://order-service.local',
            'payment' => 'http://payment-service.local'
        ];

        return $services[$serviceName] ?? throw new RuntimeException("Service $serviceName not found");
    }
}

/**
 * API Gateway
 */
class ApiGateway
{
    private ServiceDiscovery $discovery;
    private array $routes = [
        'GET /users' => ['service' => 'user', 'endpoint' => '/users'],
        'GET /users/{id}' => ['service' => 'user', 'endpoint' => '/users/{id}'],
        'POST /orders' => ['service' => 'order', 'endpoint' => '/orders'],
        'POST /payments' => ['service' => 'payment', 'endpoint' => '/payments']
    ];

    public function __construct(ServiceDiscovery $discovery)
    {
        $this->discovery = $discovery;
    }

    public function handleRequest(string $method, string $path, array $data = []): array
    {
        $routeKey = "$method $path";
        
        if (!isset($this->routes[$routeKey])) {
            // Try to match dynamic routes (like /users/{id})
            foreach ($this->routes as $routePattern => $routeConfig) {
                $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $routePattern);
                if (preg_match("#^{$pattern}$#", $routeKey, $matches)) {
                    $routeKey = $routePattern;
                    break;
                }
            }
        }

        if (!isset($this->routes[$routeKey])) {
            throw new RuntimeException("Route not found", 404);
        }

        $route = $this->routes[$routeKey];
        $serviceUrl = $this->discovery->getServiceUrl($route['service']);

        // Simulate calling the microservice
        return $this->callService($serviceUrl, $route['endpoint'], $method, $data);
    }

    private function callService(string $baseUrl, string $endpoint, string $method, array $data): array
    {
        // In a real implementation, this would make an HTTP request
        echo "Calling $method $baseUrl$endpoint with data: " . json_encode($data) . "\n";
        
        // Mock responses
        $mockResponses = [
            'GET /users' => ['users' => [['id' => 1, 'name' => 'Alice'], ['id' => 2, 'name' => 'Bob']]],
            'GET /users/{id}' => ['user' => ['id' => $data['id'] ?? 1, 'name' => 'Alice']],
            'POST /orders' => ['order_id' => uniqid(), 'status' => 'created'],
            'POST /payments' => ['payment_id' => uniqid(), 'status' => 'processed']
        ];

        $key = "$method $endpoint";
        return $mockResponses[$key] ?? ['status' => 'success'];
    }
}

// Usage
$discovery = new ServiceDiscovery('http://discovery-service.local');
$gateway = new ApiGateway($discovery);

// Handle some requests
$users = $gateway->handleRequest('GET', '/users');
$user = $gateway->handleRequest('GET', '/users/1');
$order = $gateway->handleRequest('POST', '/orders', ['product_id' => 123]);
$payment = $gateway->handleRequest('POST', '/payments', ['order_id' => $order['order_id'], 'amount' => 99.99]);

print_r(compact('users', 'user', 'order', 'payment'));

/**
 * Circuit Breaker Pattern
 */
class CircuitBreaker
{
    private string $serviceName;
    private int $failureThreshold;
    private int $resetTimeout;
    private int $failureCount = 0;
    private ?int $lastFailureTime = null;
    private bool $isOpen = false;

    public function __construct(string $serviceName, int $failureThreshold = 3, int $resetTimeout = 30)
    {
        $this->serviceName = $serviceName;
        $this->failureThreshold = $failureThreshold;
        $this->resetTimeout = $resetTimeout;
    }

    public function call(callable $serviceCall): mixed
    {
        if ($this->isOpen) {
            // Check if enough time has passed to try again
            if (time() - $this->lastFailureTime > $this->resetTimeout) {
                $this->isOpen = false;
                echo "Circuit breaker for {$this->serviceName} trying to reset\n";
            } else {
                throw new RuntimeException("Circuit breaker for {$this->serviceName} is open");
            }
        }

        try {
            $result = $serviceCall();
            $this->reset();
            return $result;
        } catch (Exception $e) {
            $this->recordFailure();
            throw $e;
        }
    }

    private function recordFailure(): void
    {
        $this->failureCount++;
        $this->lastFailureTime = time();

        if ($this->failureCount >= $this->failureThreshold) {
            $this->isOpen = true;
            echo "Circuit breaker for {$this->serviceName} tripped!\n";
        }
    }

    private function reset(): void
    {
        $this->failureCount = 0;
        $this->lastFailureTime = null;
        $this->isOpen = false;
    }
}

// Usage example with circuit breaker
$circuitBreaker = new CircuitBreaker('user-service');

try {
    $result = $circuitBreaker->call(function() {
        // Simulate a service call that might fail
        if (rand(0, 1)) {
            throw new RuntimeException("Service error");
        }
        return "Service response";
    });
    echo "Success: $result\n";
} catch (Exception $e) {
    echo "Error: {$e->getMessage()}\n";
}
