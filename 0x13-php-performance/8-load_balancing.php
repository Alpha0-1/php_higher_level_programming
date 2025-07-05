<?php
/**
 * Load Balancing in PHP
 * 
 * Techniques for distributing workload across multiple servers.
 */

class LoadBalancer
{
    private $servers = [];
    private $strategy;
    
    public function __construct(array $servers, string $strategy = 'round-robin')
    {
        if (empty($servers)) {
            throw new InvalidArgumentException('At least one server is required');
        }
        
        $this->servers = $servers;
        $this->strategy = $strategy;
        $this->currentIndex = 0;
    }
    
    /**
     * 1. Round Robin Strategy
     */
    public function getServerRoundRobin(): string
    {
        $server = $this->servers[$this->currentIndex];
        $this->currentIndex = ($this->currentIndex + 1) % count($this->servers);
        return $server;
    }
    
    /**
     * 2. Random Strategy
     */
    public function getServerRandom(): string
    {
        return $this->servers[array_rand($this->servers)];
    }
    
    /**
     * 3. Least Connections Strategy (simulated)
     */
    public function getServerLeastConnections(): string
    {
        // In a real implementation, you would track active connections
        // This is a simplified version that just picks the first server
        return $this->servers[0];
    }
    
    /**
     * 4. Session Affinity (Sticky Sessions)
     */
    public function getServerForSession(string $sessionId): string
    {
        // Consistent hashing to ensure same session goes to same server
        $hash = crc32($sessionId);
        $index = $hash % count($this->servers);
        return $this->servers[$index];
    }
    
    /**
     * Dispatch request to appropriate server
     */
    public function dispatchRequest(array $request): void
    {
        $server = match($this->strategy) {
            'random' => $this->getServerRandom(),
            'least-connections' => $this->getServerLeastConnections(),
            'session-affinity' => $this->getServerForSession($request['session_id'] ?? ''),
            default => $this->getServerRoundRobin(),
        };
        
        echo "Dispatching request to server: {$server}\n";
        // In reality, you would forward the request to the selected server
    }
}

// Usage example:
$servers = [
    'http://server1.example.com',
    'http://server2.example.com',
    'http://server3.example.com'
];

$loadBalancer = new LoadBalancer($servers, 'round-robin');

// Simulate 10 requests
for ($i = 0; $i < 10; $i++) {
    $request = [
        'path' => '/api/users',
        'method' => 'GET',
        'session_id' => 'session_' . ($i % 3) // Simulate 3 different sessions
    ];
    $loadBalancer->dispatchRequest($request);
}

/**
 * Key Takeaways:
 * 1. Load balancing distributes traffic to prevent overload
 * 2. Different strategies suit different use cases
 * 3. Session affinity is important for stateful applications
 */
?>
