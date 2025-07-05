<?php
/**
 * CodeIgniter Controllers Example
 * 
 * Demonstrates basic and RESTful controllers.
 */

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }
    
    public function view($page = 'home')
    {
        if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }
        
        $data['title'] = ucfirst($page);
        
        return view('templates/header', $data)
            . view('pages/' . $page)
            . view('templates/footer');
    }
}

// RESTful controller example:
class Products extends \CodeIgniter\RESTful\ResourceController
{
    protected $modelName = 'App\Models\ProductModel';
    protected $format = 'json';
    
    public function index()
    {
        return $this->respond($this->model->findAll());
    }
    
    public function show($id = null)
    {
        return $this->respond($this->model->find($id));
    }
}

// Routes would be configured in app/Config/Routes.php:
/*
$routes->get('pages', 'Pages::index');
$routes->get('pages/(:segment)', 'Pages::view/$1');
$routes->resource('products'); // Automatically maps to RESTful methods
*/

echo "Controller examples. Create controllers in app/Controllers.\n";
echo "Can return views, JSON responses, or redirects.\n";
?>
