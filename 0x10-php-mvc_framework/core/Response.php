<?php
/**
 * Response Class
 * Handles HTTP response data and methods
 */
class Response
{
    private $statusCode = 200;
    private $headers = [];
    private $content = '';
    
    /**
     * Set HTTP status code
     * @param int $code - Status code
     */
    public function setStatusCode($code)
    {
        $this->statusCode = $code;
    }
    
    /**
     * Set response header
     * @param string $key - Header key
     * @param string $value - Header value
     */
    public function setHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }
    
    /**
     * Set response content
     * @param string $content - Response content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
    
    /**
     * Send the response
     */
    public function send()
    {
        // Set status code
        http_response_code($this->statusCode);
        
        // Set headers
        foreach ($this->headers as $key => $value) {
            header("{$key}: {$value}");
        }
        
        // Output content
        echo $this->content;
    }
}

