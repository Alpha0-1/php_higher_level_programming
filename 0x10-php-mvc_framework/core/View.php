<?php
/**
 * View Class
 * Handles view rendering and template management
 */
class View
{
    private $viewPath;
    private $layoutPath;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->viewPath = APP_PATH . '/Views';
        $this->layoutPath = APP_PATH . '/Views/layouts';
    }
    
    /**
     * Render a view with optional layout
     * @param string $view - View name
     * @param array $data - Data to pass to view
     * @param string $layout - Layout name (optional)
     * @return string
     */
    public function render($view, $data = [], $layout = null)
    {
        // Extract data to variables
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        $viewFile = $this->viewPath . '/' . $view . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            throw new Exception("View not found: {$view}");
        }
        
        // Get view content
        $content = ob_get_clean();
        
        // If layout is specified, render with layout
        if ($layout) {
            $layoutFile = $this->layoutPath . '/' . $layout . '.php';
            if (file_exists($layoutFile)) {
                ob_start();
                include $layoutFile;
                $content = ob_get_clean();
            }
        }
        
        return $content;
    }
    
    /**
     * Include a partial view
     * @param string $partial - Partial view name
     * @param array $data - Data to pass to partial
     */
    public function partial($partial, $data = [])
    {
        extract($data);
        
        $partialFile = $this->viewPath . '/' . $partial . '.php';
        if (file_exists($partialFile)) {
            include $partialFile;
        }
    }
}

