<?php
/**
 * Router Class
 * Handles URL routing and dispatches requests to appropriate controllers
 */
class Router
{
    private $routes = [];
    private $middleware = [];
    
    /**
     * Add a GET route
     * @param string $path - URL path pattern
     * @param string $action - Controller@method format
     * @param array $middleware - Optional middleware
     */
    public function get($path, $action, $middleware = [])
    {
        $this->addRoute('GET', $path, $action, $middleware);
    }
    
    /**
     * Add a POST route
     * @param string $path - URL path pattern
     * @param string $action - Controller@method format
     * @param array $middleware - Optional middleware
     */
    public function post($path, $action, $middleware = [])
    {
        $this->addRoute('POST', $path, $action, $middleware);
    }
    
    /**
     * Add a PUT route
     * @param string $path - URL path pattern
     * @param string $action - Controller@method format
     * @param array $middleware - Optional middleware
     */
    public function put($path, $action, $middleware = [])
    {
        $this->addRoute('PUT', $path, $action, $middleware);
    }
    
    /**
     * Add a DELETE route
     * @param string $path - URL path pattern
     * @param string $action - Controller@method format
     * @param array $middleware - Optional middleware
     */
    public function delete($path, $action, $middleware = [])
    {
        $this->addRoute('DELETE', $path, $action, $middleware);
    }
    
    /**
     * Add a route to the routes array
     * @param string $method - HTTP method
     * @param string $path - URL path pattern
     * @param string $action - Controller@method format
     * @param array $middleware - Optional middleware
     */
    private function addRoute($method, $path, $action, $middleware = [])
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'action' => $action,
            'middleware' => $middleware
        ];
    }
    
    /**
     * Handle incoming request and route to appropriate controller
     * @param Request $request - Request object
     * @param Response $response - Response object
     */
    public function handle(Request $request, Response $response)
    {
        $requestPath = $request->getPath();
        $requestMethod = $request->getMethod();
        
        foreach ($this->routes as $route) {
            if ($this->matchRoute($route, $requestMethod, $requestPath)) {
                // Extract parameters from URL
                $params = $this->extractParams($route['path'], $requestPath);
                
                // Execute middleware if any
                foreach ($route['middleware'] as $middleware) {
                    if (!$this->executeMiddleware($middleware, $request, $response)) {
                        return;
                    }
                }
                
                // Dispatch to controller
                $this->dispatch($route['action'], $params, $request, $response);
                return;
            }
        }
        
        // No route found - 404 error
        $response->setStatusCode(404);
        $response->setContent('404 - Page Not Found');
        $response->send();
    }
    
    /**
     * Check if route matches the request
     * @param array $route - Route configuration
     * @param string $method - Request method
     * @param string $path - Request path
     * @return bool
     */
    private function matchRoute($route, $method, $path)
    {
        if ($route['method'] !== $method) {
            return false;
        }
        
        $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route['path']);
        $pattern = '#^' . $pattern . '$#';
        
        if (preg_match($pattern, $requestPath, $matches)) {
            $params = [];
            foreach ($matches as $key => $value) {
                if (!is_numeric($key)) {
                    $params[$key] = $value;
                }
            }
            return $params;
        }
        
        return [];
    }
    
    /**
     * Execute middleware
     * @param string $middleware - Middleware class name
     * @param Request $request - Request object
     * @param Response $response - Response object
     * @return bool
     */
    private function executeMiddleware($middleware, Request $request, Response $response)
    {
        $middlewareInstance = new $middleware();
        return $middlewareInstance->handle($request, $response);
    }
    
    /**
     * Dispatch request to controller method
     * @param string $action - Controller@method format
     * @param array $params - URL parameters
     * @param Request $request - Request object
     * @param Response $response - Response object
     */
    private function dispatch($action, $params, Request $request, Response $response)
    {
        list($controllerName, $methodName) = explode('@', $action);
        
        if (!class_exists($controllerName)) {
            $response->setStatusCode(500);
            $response->setContent('Controller not found: ' . $controllerName);
            $response->send();
            return;
        }
        
        $controller = new $controllerName();
        
        if (!method_exists($controller, $methodName)) {
            $response->setStatusCode(500);
            $response->setContent('Method not found: ' . $methodName);
            $response->send();
            return;
        }
        
        // Inject dependencies
        $controller->setRequest($request);
        $controller->setResponse($response);
        
        // Call controller method with parameters
        call_user_func_array([$controller, $methodName], $params);
    }
}
