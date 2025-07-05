<?php
/**
 * Request Class
 * Handles HTTP request data and methods
 */
class Request
{
    private $method;
    private $uri;
    private $path;
    private $query;
    private $post;
    private $files;
    private $headers;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->path = parse_url($this->uri, PHP_URL_PATH);
        $this->query = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->headers = $this->getHeaders();
    }
    
    /**
     * Get request method
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
    
    /**
     * Get request URI
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }
    
    /**
     * Get request path
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * Get query parameters
     * @param string $key - Optional key to get specific parameter
     * @return mixed
     */
    public function query($key = null)
    {
        if ($key === null) {
            return $this->query;
        }
        
        return isset($this->query[$key]) ? $this->query[$key] : null;
    }
    
    /**
     * Get POST data
     * @param string $key - Optional key to get specific data
     * @return mixed
     */
    public function post($key = null)
    {
        if ($key === null) {
            return $this->post;
        }
        
        return isset($this->post[$key]) ? $this->post[$key] : null;
    }
    
    /**
     * Get request input (POST or GET)
     * @param string $key - Input key
     * @return mixed
     */
    public function input($key)
    {
        if (isset($this->post[$key])) {
            return $this->post[$key];
        }
        
        if (isset($this->query[$key])) {
            return $this->query[$key];
        }
        
        return null;
    }
    
    /**
     * Get uploaded files
     * @param string $key - Optional key to get specific file
     * @return mixed
     */
    public function file($key = null)
    {
        if ($key === null) {
            return $this->files;
        }
        
        return isset($this->files[$key]) ? $this->files[$key] : null;
    }
    
    /**
     * Get request headers
     * @return array
     */
    private function getHeaders()
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $header = str_replace('_', '-', substr($key, 5));
                $headers[strtolower($header)] = $value;
            }
        }
        return $headers;
    }
    
    /**
     * Get specific header
     * @param string $key - Header key
     * @return string|null
     */
    public function header($key)
    {
        $key = strtolower($key);
        return isset($this->headers[$key]) ? $this->headers[$key] : null;
    }
    
    /**
     * Check if request is AJAX
     * @return bool
     */
    public function isAjax()
    {
        return strtolower($this->header('x-requested-with')) === 'xmlhttprequest';
    }
}
