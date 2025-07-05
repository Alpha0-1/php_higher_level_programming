<?php
/**
 * Custom PHP Framework Example
 * 
 * Demonstrates building a simple MVC framework from scratch.
 */

// 1. Front Controller (public/index.php)
/*
require __DIR__ . '/../vendor/autoload.php';

$router = new Core\Router();
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');

$router->dispatch($_SERVER['QUERY_STRING']);
*/

// 2. Router Class (Core/Router.php)
/*
namespace Core;

class Router
{
    protected $routes = [];
    
    public function add($route, $params = []) { ... }
    
    public function dispatch($url) 
    {
        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $action = $this->params['action'];
            
            $controller = "App\Controllers\\" . ucfirst($controller);
            if (class_exists($controller)) {
                $controller_object = new $controller();
                
                if (is_callable([$controller_object, $action])) {
                    $controller_object->$action();
                }
            }
        }
    }
}
*/

// 3. Base Controller (Core/Controller.php)
/*
namespace Core;

class Controller
{
    protected function view($view, $data = [])
    {
        extract($data);
        require "App/Views/$view.php";
    }
}
*/

// 4. Example Controller (App/Controllers/Home.php)
/*
namespace App\Controllers;

use Core\Controller;

class Home extends Controller
{
    public function index()
    {
        $data = ['name' => 'Custom Framework'];
        $this->view('home/index', $data);
    }
}
*/

// 5. View (App/Views/home/index.php)
/*
<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome to <?= htmlspecialchars($name) ?></h1>
</body>
</html>
*/

echo "Custom Framework Example\n\n";
echo "Key components to build:\n";
echo "1. Front controller (single entry point)\n";
echo "2. Router (maps URLs to controllers/actions)\n";
echo "3. Controller base class\n";
echo "4. View rendering system\n";
echo "5. Model/Database abstraction (optional)\n\n";
echo "This demonstrates the basic MVC pattern that frameworks use.\n";
echo "Real frameworks add many more features like:\n";
echo "- Dependency injection\n";
echo "- Middleware\n";
echo "- Configuration systems\n";
echo "- ORM/Query builders\n";
echo "- Templating engines\n";
?>
