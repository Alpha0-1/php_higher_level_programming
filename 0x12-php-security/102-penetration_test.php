<?php
/**
 * Basic penetration testing helper functions
 * 
 */

class PenTestHelper {
    // Check for common vulnerabilities in a URL
    public static function testUrl($url) {
        $tests = [
            'SQL Injection' => "' OR '1'='1",
            'XSS' => '<script>alert("XSS")</script>',
            'Directory Traversal' => '../../../../etc/passwd',
            'Command Injection' => '; ls -la',
        ];
        
        $results = [];
        $client = new GuzzleHttp\Client();
        
        foreach ($tests as $name => $payload) {
            try {
                // Test GET parameter
                $testUrl = $url . (strpos($url, '?') === false ? '?' : '&') . 'test=' . urlencode($payload);
                $response = $client->get($testUrl, [
                    'http_errors' => false,
                    'timeout' => 5
                ]);
                
                $status = $response->getStatusCode();
                $body = (string)$response->getBody();
                
                $results[$name] = [
                    'status' => $status,
                    'vulnerable' => $this->checkVulnerability($name, $status, $body)
                ];
            } catch (Exception $e) {
                $results[$name] = [
                    'error' => $e->getMessage()
                ];
            }
        }
        
        return $results;
    }
    
    protected function checkVulnerability($type, $status, $body) {
        switch ($type) {
            case 'SQL Injection':
                return preg_match('/SQL syntax|MySQL server|syntax error/', $body);
            case 'XSS':
                return strpos($body, '<script>alert("XSS")</script>') !== false;
            case 'Directory Traversal':
                return preg_match('/root:\w+:\d+:\d+:/', $body);
            case 'Command Injection':
                return preg_match('/total \d+/', $body);
            default:
                return false;
        }
    }
    
    // Check for open ports on a host
    public static function portScan($host, $ports = [80, 443, 22, 21, 3306]) {
        $results = [];
        
        foreach ($ports as $port) {
            $connection = @fsockopen($host, $port, $errno, $errstr, 2);
            if (is_resource($connection)) {
                $results[$port] = 'OPEN';
                fclose($connection);
            } else {
                $results[$port] = 'CLOSED';
            }
        }
        
        return $results;
    }
    
    // Check for HTTP security headers
    public static function checkHeaders($url) {
        $client = new GuzzleHttp\Client();
        $response = $client->get($url);
        $headers = $response->getHeaders();
        
        $importantHeaders = [
            'Content-Security-Policy',
            'X-Content-Type-Options',
            'X-Frame-Options',
            'X-XSS-Protection',
            'Strict-Transport-Security',
            'Referrer-Policy'
        ];
        
        $results = [];
        foreach ($importantHeaders as $header) {
            $results[$header] = isset($headers[$header]) ? $headers[$header][0] : 'MISSING';
        }
        
        return $results;
    }
}

// Example usage (requires GuzzleHTTP
