<?php
/**
 * Base Controller Class
 * Provides common functionality for all controllers
 */
class Controller
{
    protected $request;
    protected $response;
    protected $session;
    protected $validator;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->session = new Session();
        $this->validator = new Validator();
    }
    
    /**
     * Set request object
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }
    
    /**
     * Set response object
     * @param Response $response
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }
    
    /**
     * Render a view with data
     * @param string $view - View name (e.g., 'home/index')
     * @param array $data - Data to pass to view
     * @param string $layout - Layout to use (default: 'app')
     */
    protected function view($view, $data = [], $layout = 'app')
    {
        $viewInstance = new View();
        $content = $viewInstance->render($view, $data, $layout);
        $this->response->setContent($content);
        $this->response->send();
    }
    
    /**
     * Redirect to another URL
     * @param string $url - URL to redirect to
     * @param int $statusCode - HTTP status code (default: 302)
     */
    protected function redirect($url, $statusCode = 302)
    {
        $this->response->setStatusCode($statusCode);
        $this->response->setHeader('Location', $url);
        $this->response->send();
    }
    
    /**
     * Return JSON response
     * @param mixed $data - Data to encode as JSON
     * @param int $statusCode - HTTP status code (default: 200)
     */
    protected function json($data, $statusCode = 200)
    {
        $this->response->setStatusCode($statusCode);
        $this->response->setHeader('Content-Type', 'application/json');
        $this->response->setContent(json_encode($data));
        $this->response->send();
    }
    
    /**
     * Validate request data
     * @param array $data - Data to validate
     * @param array $rules - Validation rules
     * @return bool
     */
    protected function validate($data, $rules)
    {
        return $this->validator->validate($data, $rules);
    }
    
    /**
     * Get validation errors
     * @return array
     */
    protected function getValidationErrors()
    {
        return $this->validator->getErrors();
    }
}
