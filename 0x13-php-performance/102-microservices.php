<?php
/**
 * Microservices Architecture in PHP
 * 
 * Implementation patterns for microservices with PHP.
 */

/**
 * 1. Service Client Implementation
 */
class ProductServiceClient
{
    private $httpClient;
    private $baseUrl;
    
    public function __construct(HttpClientInterface $httpClient, string $baseUrl)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = rtrim($baseUrl, '/');
    }
    
    public function getProduct(int $id): ?array
    {
        $response = $this->httpClient->get("{$this->baseUrl}/products/{$id}");
        
        if ($response->getStatusCode() !== 200) {
            return null;
        }
        
        return json_decode($response->getBody(), true);
    }
    
    public function createProduct(array $data): array
    {
        $response = $this->httpClient->post(
            "{$this->baseUrl}/products",
            ['json' => $data]
        );
        
        return json_decode($response->getBody(), true);
    }
}

/**
 * 2. Circuit Breaker Pattern
 */
class CircuitBreaker
{
    private $service;
    private $failureCount = 0;
    private $lastFailureTime = 0;
    private $threshold = 3;
    private $timeout = 30;
    
    public function __construct(callable $service)
    {
        $this->service = $service;
    }
    
    public function execute()
    {
        if ($this->isOpen()) {
            throw new RuntimeException('Service unavailable (circuit breaker open)');
        }
        
        try {
            $result = ($this->service)();
            $this->reset();
            return $result;
        } catch (Exception $e) {
            $this->recordFailure();
            throw $e;
        }
    }
    
    private function isOpen(): bool
    {
        return $this->failureCount >= $this->threshold && 
               time() - $this->lastFailureTime < $this->timeout;
    }
    
    private function recordFailure(): void
    {
        $this->failureCount++;
        $this->lastFailureTime = time();
    }
    
    private function reset(): void
    {
        $this->failureCount = 0;
        $this->lastFailureTime = 0;
    }
}

/**
 * 3. Service Discovery
 */
class ServiceDiscovery
{
    private $registry;
    
    public function __construct(array $registry)
    {
        $this->registry = $registry;
    }
    
    public function getServiceUrl(string $serviceName): string
    {
        if (!isset($this->registry[$serviceName])) {
            throw new InvalidArgumentException("Service $serviceName not found");
        }
        
        $instances = $this->registry[$serviceName];
        return $instances[array_rand($instances)]; // Simple random load balancing
    }
}

/**
 * 4. API Gateway Pattern
 */
class ApiGateway
{
    private $services;
    private $httpClient;
    
    public function __construct(array $services, HttpClientInterface $httpClient)
    {
        $this->services = $services;
        $this->httpClient = $httpClient;
    }
    
    public function handleRequest(string $path, array $request): array
    {
        // Route to appropriate microservice
        if (str_starts_with($path, '/products')) {
            $serviceUrl = $this->services['product_service'];
            $response = $this->httpClient->request(
                $request['method'],
                $serviceUrl . $path,
                $request['options'] ?? []
            );
            
            return json_decode($response->getBody(), true);
        }
        
        // Similar routing for other services...
        
        throw new InvalidArgumentException("No route for path $path");
    }
}

/**
 * 5. Distributed Tracing
 */
class RequestTracer
{
    private $requestId;
    private $parentId;
    private $startTime;
    
    public function __construct(?string $requestId = null, ?string $parentId = null)
    {
        $this->requestId = $requestId ?? uniqid();
        $this->parentId = $parentId;
        $this->startTime = microtime(true);
    }
    
    public function logEvent(string $service, string $event): void
    {
        $logEntry = [
            'timestamp' => microtime(true),
            'request_id' => $this->requestId,
            'parent_id' => $this->parentId,
            'service' => $service,
            'event' => $event,
            'duration' => microtime(true) - $this->startTime
        ];
        
        // In reality, send to centralized logging
        error_log(json_encode($logEntry));
    }
    
    public function getTraceHeaders(): array
    {
        return [
            'X-Request-ID' => $this->requestId,
            'X-Parent-ID' => $this->parentId ?? $this->requestId
        ];
    }
}

/**
 * Key Takeaways:
 * 1. Microservices promote separation of concerns
 * 2. Need robust service discovery and communication
 * 3. Implement resilience patterns like circuit breakers
 */
?>
